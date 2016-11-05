<?php

namespace AppBundle\Controller\Secretaria;

use AppBundle\Controller\DSIController;
use AppBundle\Entity\Curso;
use AppBundle\Entity\HorarioCurso;
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

            $hc=$this->mostrarHC();
            $fechaAhora=(new \DateTime('now',new \DateTimeZone('America/El_Salvador')))->format("Y-m-d");
            for($i=0;$i<count($hc);$i++){
                if($fechaAhora>$hc[$i]{"fecha_fin"}){
                    $id=$em->getRepository('AppBundle:Curso')->find($hc[$i]{"id_curso"});
                    $id->setEstadoCurso("Desabilitado");

                    //Guradar en la BD
                    $em->flush();
                }
            }

            $doctores=$em->getRepository('AppBundle:Doctores')->findAll();

            $d1=$this->mostrarD1();

            return $this->render('AppBundle:Secretaria/Curso:curso.html.twig', array('cursos'=>$cursos,'doctores'=>$doctores,'d1'=>$d1, 'hc'=>$hc));
        }else{
            return $this->redirectToRoute('login');
        }

    }

    /**
     *
     * @Route("/secretaria/curso_create",name="createCurso")
     */
    public function createCursoAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $tc=$em->getRepository("AppBundle:TipoCurso")->findAll();
        $doc = $this->mostrarDoctores();

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
                                return new Response("Error el Curso ya ha sido registrado!");
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
                                $curso->setEstadoCurso("Registro");

                                //Persistir
                                $em->persist($curso);

                                //Proceso de almacenamiento de datos de entidad Horario Curso
                                $horario=new HorarioCurso();
                                $horario->setFechaInicio(new \DateTime($request->get("fechaini")));
                                $horario->setFechaFin(new \DateTime($request->get("fechafin")));
                                $horario->setInicioRecepDoc(new \DateTime($request->get("fechainirec")));
                                $horario->setFinRecepDoc(new \DateTime($request->get("fechafinrec")));
                                $horario->setDefechaEntrevista(new \DateTime($request->get("fechainientre")));
                                $horario->setAfechaEntrevista(new \DateTime($request->get("fechafinentre")));
                                $horario->setDefechaEvaluacion(new \DateTime($request->get("fechainieva")));
                                $horario->setAfechaEvaluacion(new \DateTime($request->get("fechafineva")));

                                //Persistir
                                $em->persist($horario);

                                //Guradar en la BD
                                $em->flush();

                                //Subiendo la Imagen
                                $this->subirImagen('imagen',$nombreImagen);
                                //Subiendo el PDF
                                $this->subirPDF('archivo',$nombrePDF);

                                $idcurso=$curso->getIdCurso();

                                //Manejando relacion de muchos a muchos
                                for ($i = 0; $i < count($array_doc); $i++) {

                                    $this->manytomany($idcurso,$array_doc[$i]);
                                }
                                $this->updateHC($horario->getIdHc(),$idcurso);
                                $this->MensajeFlash('exito','Curso creado correctamente!');
                                return $this->redirectToRoute("verCurso");
                            }
                        }else
                            return new Response('El Archivo no es un archivo PDF');
                    }
                    else
                        return new Response('El Archivo no es una imagen');
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
        $em=$this->getDoctrine()->getManager();
        $doc=$this->mostrarDoctores();
        $tc=$em->getRepository("AppBundle:TipoCurso")->findAll();
        $datos=$em->getRepository('AppBundle:Curso')->find($id);
        $id_hc=$this->IdHCcurso($id){"id_hc"};
        $hc=$em->getRepository('AppBundle:HorarioCurso')->find($id_hc);
        $d1=$this->mostrarD1s($id);
        /*var_dump($d1);
        die();*/

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
                            $datos->setIdTc($em->getRepository("AppBundle:TipoCurso")->find($tc));
                            $datos->setNombreCurso($nom_cur);
                            $datos->setCantAlumnosLimit($can_alum);
                            $datos->setTextoInformativo($des_info);
                            $datos->setBroshureInformativo("img/brochure/".$nombreImagen);
                            $datos->setNumCuotas($nun_cuo);
                            $datos->setRutaPdf("img/pdf/".$nombrePDF);
                            $datos->setEstadoCurso("Registro");

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

                            //Subiendo la Imagen
                            $this->subirImagen('imagen',$nombreImagen);
                            //Subiendo el PDF
                            $this->subirPDF('archivo',$nombrePDF);

                            $this->del_d1($id);

                            //Manejando relaci�n de muchos a muchos
                            for ($i = 0; $i < count($array_doc); $i++) {

                                $this->manytomany($id,$array_doc[$i]);
                            }
                            $this->MensajeFlash('exito','El Curso se Edito correctamente!');
                            return $this->redirectToRoute("verCurso");

                        }else
                            return new Response('El Archivo no es un archivo PDF');
                    }
                    else
                        return new Response('El Archivo no es una imagen');
                }
            }
        }
        return $this->render("AppBundle:Secretaria/Curso:curso_edit.html.twig",array("tc"=>$tc,'datos'=>$datos,"doc"=>$doc,"hc"=>$hc,"d1"=>$d1));
    }


    /**
     * @Route("/secretaria/curso_desabilitar/{idcurso}",name="desCurso")
     */
    public function desabilitarAction($idcurso, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $curso=$em->getRepository('AppBundle:Curso')->find($idcurso);
        if(!$curso){
            throw $this->createNotFoundException('No existe el usuario con el ID'.$idcurso);
        }

        $curso->setEstadoCurso("Desabilitado");

        //Guradar en la BD
        $em->flush();

        $this->MensajeFlash('exito','Curso se ha Desabilitado correctamente');

        return $this->redirectToRoute("verCurso");
    }
}