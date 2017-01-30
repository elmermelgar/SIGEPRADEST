<?php

namespace AppBundle\Controller\Secretaria;

use AppBundle\Controller\DSIController;
use AppBundle\Entity\Curso;
use AppBundle\Entity\HorarioCurso;
use AppBundle\Entity\Modulos;
use AppBundle\Entity\TipoCurso;
use AppBundle\Tests\Controller\DetalleCursoControllerTest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;


class CursoController extends DSIController
{
    /**
     * @Route("/secretaria/cursos",name="verCurso")
     */
    public function verCursoAction()
    {
        if($this->getUser()){
            $em=$this->getDoctrine()->getManager("default");
            $cursos=$em->getRepository('AppBundle:Curso')->findAll();
            $hc=$em->createQuery('select curso from AppBundle:HorarioCurso curso ORDER BY curso.fechaInicio DESC ')->getResult();

            $fechaAhora=(new \DateTime('now',new \DateTimeZone('America/El_Salvador')))->format("Y-m-d");
            for($i=0;$i<count($hc);$i++){
                if($fechaAhora>($hc[$i]->getFechaFin()->format("Y-m-d"))){
                    $id=$em->getRepository('AppBundle:Curso')->find($hc[$i]->getIdCurso());
                    $id->setEstadoCurso("finanlizado");
                    //Guardar en la BD
                    $em->flush();
                }
            }
            return $this->render('AppBundle:Secretaria/Curso:curso.html.twig', array('cursos'=>$cursos,'hc'=>$hc));
        }else{
            return $this->redirectToRoute('login');
        }

    }

    /**
     * @Route("/secretaria/curso_ver/{id}",name="detallesCurso")
     */
    public function detallesAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $doc = $em->getRepository("AppBundle:Doctores")->findBy(array(),array('nombreDoc'=>'ASC'));
        $tc=$em->getRepository("AppBundle:TipoCurso")->findAll();
        $datos=$em->getRepository('AppBundle:Curso')->find($id);
        $hc=$em->getRepository('AppBundle:HorarioCurso')->findOneBy(array('idCurso'=> $id));
        $id_hc=$hc->getIdHc();
        $hc=$em->getRepository('AppBundle:HorarioCurso')->find($id_hc);
        $d1=$this->mostrarD1s($id);
        $cuota=$em->getRepository('AppBundle:Cuotas')->findBy(array('idCurso'=> $id));

        return $this->render("AppBundle:Secretaria/Curso:curso_ver.html.twig",array("tc"=>$tc,'datos'=>$datos,"doc"=>$doc,"hc"=>$hc,"d1"=>$d1, 'cuota'=>$cuota));
    }
    /**
     * @Route("/secretaria/historial", name="historial")
     */
    public function secretariaAction()
    {
        $em=$this->getDoctrine()->getManager("default");
        $cursos=$em->getRepository('AppBundle:Curso')->findAll();
        return $this->render('AppBundle:Secretaria/Curso:historialcursos.html.twig', array('cursos'=>$cursos));
    }

    /**
     *
     * @Route("/secretaria/curso_create",name="createCurso")
     */
    public function createCursoAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $tc=$em->getRepository("AppBundle:TipoCurso")->findAll();
        $doc = $em->getRepository("AppBundle:Doctores")->findBy(array(),array('nombreDoc'=>'ASC'));

        //Verificando que hay una peticion POST
        if($request->isMethod("POST")) {
            if ($_FILES["imagen"]["error"] > 0){
                return new Response('Error en la subida de la imagen');
            }else{
                if($_FILES["archivo"]["error"] > 0){
                    return new Response('Error en la subida de la del PDF');
                }else {
                    if($this->infoTipoImagen('imagen')[0]=='image'){
                        if($this->infoTipoImagen('archivo')[0]=='application'){
                            $nomCurso=$request->get('nombrecurso');
                            if($em->getRepository('AppBundle:Curso')->findOneBy(array('nombreCurso'=>$nomCurso)))
                            {
                                $this->MensajeFlash('error','Error el Curso ya ha sido registrado!');
                                return $this->render("AppBundle:Secretaria/Curso:curso_create.html.twig",array("tc"=>$tc,"doc"=>$doc));
                            }
                            else {
                                $nombreImagen=$nomCurso.$this->infoTipoImagen('imagen')[1];
                                $nombrePDF=$nomCurso.$this->infoTipoImagen('archivo')[1];

                                //Recuperar valores enviados
                                $nom_cur = $request->get("nombrecurso");
                                $nun_cuo = $request->get("nun_cuo");
                                $can_alum = $request->get("cant_alum");
                                $des_info = $request->get("des_info");
                                $tc = $request->get("tc");
                                $array_doc = $request->get("doc");

                                //Proceso de almacenamiento de datos en entidad Curso
                                $curso=new Curso();
                                $curso->setIdTc($em->getRepository("AppBundle:TipoCurso")->find($tc));
                                $curso->setNombreCurso($nom_cur);
                                $curso->setCantAlumnosLimit($can_alum);
                                $curso->setTextoInformativo($des_info);
                                $curso->setBroshureInformativo("img/brochure/".$nombreImagen);
                                $curso->setNumCuotas($nun_cuo);
                                $curso->setRutaPdf("img/pdf/".$nombrePDF);
                                $curso->setEstadoCurso("registro");

                                //Persistir
                                $em->persist($curso);
                                $idcurso=$curso->getIdCurso();

                                //Proceso de almacenamiento de datos de entidad Horario Curso
                                $horario=new HorarioCurso();
                                $horario->setIdCurso($em->getRepository("AppBundle:Curso")->find($idcurso));
                                $horario->setFechaInicio(new \DateTime($request->get("fechaini")));
                                $horario->setFechaFin(new \DateTime($request->get("fechafin")));
                                $horario->setInicioRecepDoc(new \DateTime($request->get("fechainirec")));
                                $horario->setFinRecepDoc(new \DateTime($request->get("fechafinrec")));
                                $horario->setDefechaEntrevista(new \DateTime($request->get("fechainientre")));
                                $horario->setAfechaEntrevista(new \DateTime($request->get("fechafinentre")));
                                $horario->setDefechaEvaluacion(new \DateTime($request->get("fechainieva")));
                                $horario->setAfechaEvaluacion(new \DateTime($request->get("fechafineva")));

                                $modulo= new Modulos();
                                $modulo->setIdCurso($em->getRepository("AppBundle:Curso")->find($idcurso));
                                $modulo->setNombreModulo('Modulo 1-'.$curso->getNombreCurso());

                                //Persistir
                                $em->persist($modulo);
                                $em->persist($horario);

                                //Guradar en la BD
                                $em->flush();

                                //Subiendo la Imagen
                                $this->subirImagen('imagen',$nombreImagen);
                                //Subiendo el PDF
                                $this->subirPDF('archivo',$nombrePDF);
                                //Manejando relacion de muchos a muchos
                                for ($i = 0; $i < count($array_doc); $i++) {

                                    $this->manytomany($idcurso,$array_doc[$i]);
                                }
                                $this->updateHC($horario->getIdHc(),$idcurso);
                                $this->MensajeFlash('exito','Curso creado correctamente!');
                                return $this->redirectToRoute("verCurso");
                            }
                        }else{
                            $this->MensajeFlash('error','El archivo no es un PDF!');
                            return $this->render("AppBundle:Secretaria/Curso:curso_create.html.twig",array("tc"=>$tc,"doc"=>$doc));
                        }
                    }else{
                        $this->MensajeFlash('error','El archivo no es una imagen!');
                        return $this->render("AppBundle:Secretaria/Curso:curso_create.html.twig",array("tc"=>$tc,"doc"=>$doc));
                    }
                }
            }
        }
        return $this->render("AppBundle:Secretaria/Curso:curso_create.html.twig",array("tc"=>$tc,"doc"=>$doc));
    }

    /**
     * @Route("/secretaria/curso_edit/{id}",name="editCurso")
     */
    public function editCursoAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //$doc = $em->getRepository("AppBundle:Doctores")->findBy(array(),array('nombreDoc'=>'ASC'));

        $tc = $em->getRepository("AppBundle:TipoCurso")->findAll();
        $datos = $em->getRepository('AppBundle:Curso')->find($id);
        $hc = $em->getRepository('AppBundle:HorarioCurso')->findOneBy(array('idCurso' => $id));
        $id_hc = $hc->getIdHc();
        $hc = $em->getRepository('AppBundle:HorarioCurso')->find($id_hc);
        $d1 = $this->mostrarD1s($id);

        $db = $em->getConnection();
        $sql = "SELECT r.*,d.id_doctores,d.nombre_doc,d.apellido_doc FROM doctores d LEFT JOIN d1 r ON d.id_doctores = r.id_doctores AND r.id_curso = $id";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $doc = $stmt->fetchAll();

        //Verificando que hay una peticion POST
        if ($request->isMethod("POST")) {

            //Recuperar valores enviados
            $nom_cur = $request->get("nombrecurso");
            $nun_cuo = $request->get("nun_cuo");
            $can_alum = $request->get("cant_alum");
            $des_info = $request->get("des_info");
            $tc = $request->get("tc");
            $array_doc = $request->get("doc");

            //Proceso de almacenamiento de datos en entidad Curso
            $datos->setIdTc($em->getRepository("AppBundle:TipoCurso")->find($tc));
            $datos->setNombreCurso($nom_cur);
            $datos->setCantAlumnosLimit($can_alum);
            $datos->setTextoInformativo($des_info);

            $datos->setNumCuotas($nun_cuo);

            //Proceso de almacenamiento de datos de entidad Horario Curso
            $hc->setFechaInicio(new \DateTime($request->get("fechaini")));
            $hc->setFechaFin(new \DateTime($request->get("fechafin")));
            $hc->setInicioRecepDoc(new \DateTime($request->get("fechainirec")));
            $hc->setFinRecepDoc(new \DateTime($request->get("fechafinrec")));
            $hc->setDefechaEntrevista(new \DateTime($request->get("fechainientre")));
            $hc->setAfechaEntrevista(new \DateTime($request->get("fechafinentre")));
            $hc->setDefechaEvaluacion(new \DateTime($request->get("fechainieva")));
            $hc->setAfechaEvaluacion(new \DateTime($request->get("fechafineva")));

            //Guradar en la BD
            $em->flush();

            $this->del_d1($id);

            //Manejando relación de muchos a muchos
            for ($i = 0; $i < count($array_doc); $i++) {

                $this->manytomany($id, $array_doc[$i]);
            }
            $this->MensajeFlash('exito', 'El Curso se Edito correctamente!');
            return $this->redirectToRoute("verCurso");

        }
        return $this->render("AppBundle:Secretaria/Curso:curso_edit.html.twig", array("tc" => $tc, 'datos' => $datos, "doc" => $doc, "hc" => $hc, "d1" => $d1));
    }

    /**
     * @Route("/secretaria/curso_disponible/{idcurso}",name="disCurso")
     */
    public function disponibleAction($idcurso)
    {
        $em=$this->getDoctrine()->getManager();
        $curso=$em->getRepository('AppBundle:Curso')->find($idcurso);
        if(!$curso){
            throw $this->createNotFoundException('No existe el curso con el ID'.$idcurso);
        }

        $curso->setEstadoCurso("disponible");

        //Guradar en la BD
        $em->flush();

        $this->MensajeFlash('exito','Curso se ha puesto en estado Disponible correctamente');

        return $this->redirectToRoute("verCurso");
    }

    /**
     * @Route("/secretaria/curso_desabilitar/{idcurso}",name="desCurso")
     */
    public function desabilitarAction($idcurso, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $curso=$em->getRepository('AppBundle:Curso')->find($idcurso);
        if(!$curso){
            throw $this->createNotFoundException('No existe el el curso con el ID'.$idcurso);
        }

        $curso->setEstadoCurso("desabilitado");

        //Guradar en la BD
        $em->flush();

        $this->MensajeFlash('exito','Curso se ha Deshabilitado correctamente');

        return $this->redirectToRoute("verCurso");
    }

    /**
     * @Route("/secretaria/curso_cambiarImg/{idcurso}",name="camImg")
     */
    public function cambiarImg($idcurso, Request $request){
        $em = $this->getDoctrine()->getManager();
        $c = $em->getRepository('AppBundle:Curso')->find($idcurso);

        //Verificando que hay una peticion POST
        if($request->isMethod("POST")) {
            if ($_FILES["imagen"]["error"] > 0) {
                return new Response('Error en la subida de la imagen');
            } else {
                if ($this->infoTipoImagen('imagen')[0] == 'image') {
                    $nomCurso = $c->getNombreCurso();
                    $nombreImagen = $nomCurso . $this->infoTipoImagen('imagen')[1];
                    //Subiendo la Imagen
                    $this->subirImagen('imagen', $nombreImagen);
                    $this->MensajeFlash('exito', 'Imagen del curso editada correctamente!');
                    return $this->redirectToRoute("detallesCurso", array('id' => $idcurso));
                } else {
                    $this->MensajeFlash('error', 'El archivo no es una imagen!');
                    return $this->redirectToRoute("detallesCurso", array('id' => $idcurso));
                }
            }
        }

    }

    /**
     * @Route("/secretaria/curso_cambiarPDF/{idcurso}",name="camPDF")
     */
    public function cambiarPDF($idcurso, Request $request){
        $em = $this->getDoctrine()->getManager();
        $c = $em->getRepository('AppBundle:Curso')->find($idcurso);

        //Verificando que hay una peticion POST
        if($request->isMethod("POST")) {
            if($_FILES["archivo"]["error"] > 0){
                return new Response('Error en la subida de la del PDF');
            }else {
                if($this->infoTipoImagen('archivo')[0]=='application'){
                    $nomCurso=$c->getNombreCurso();
                    $nombrePDF=$nomCurso.$this->infoTipoImagen('archivo')[1];
                    //Subiendo el PDF
                    $this->subirPDF('archivo',$nombrePDF);
                    $this->MensajeFlash('exito','PDF del curso editado correctamente!');
                    return $this->redirectToRoute("detallesCurso",array('id'=>$idcurso));
                }
                else{
                    $this->MensajeFlash('error','El archivo no es un PDF!');
                    return $this->redirectToRoute("detallesCurso",array('id'=>$idcurso));
                }
            }
        }
    }


}
