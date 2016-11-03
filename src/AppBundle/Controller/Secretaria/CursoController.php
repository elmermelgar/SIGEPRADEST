<?php

namespace AppBundle\Controller\Secretaria;

use AppBundle\Controller\DSIController;
use AppBundle\Entity\Curso;
use AppBundle\Entity\HorarioCurso;
use AppBundle\Entity\TipoCurso;
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
            $doctores=$em->getRepository('AppBundle:Doctores')->findAll();

            $d1=$this->mostrarD1();

            return $this->render('AppBundle:Secretaria/Curso:curso.html.twig', array('cursos'=>$cursos,'doctores'=>$doctores,'d1'=>$d1));
        }else{
            return $this->redirectToRoute('login');
        }

    }

    /**
     * @Route("/secretaria/curso_create",name="createCurso")
     */
    public function createCursoAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $tc=$em->getRepository("AppBundle:TipoCurso")->findAll();

        $doc = $this->mostrarCursos();

        //Verificando que hay una peticion POST
        if($request->isMethod("POST")) {
            if ($_FILES["imagen"]["error"] > 0 && $_FILES["archivo"]["error"] > 0)
                return new Response('Error en subida de Imagen o de PDF');

            else {
                if($this->infoTipoImagen('imagen')[0]=='image' && $this->infoTipoImagen('archivo')[0]=='application')
                {
                    $nomCurso=$request->get('nombrecurso');

                    if($em->getRepository('AppBundle:Curso')->findOneBy(array('nombreCurso'=>$nomCurso)))
                    {
                        return new Response("El Curso ya ha sido registrado!");
                    }
                    else {
                        $nombreImagen=$nomCurso.$this->infoTipoImagen('imagen')[1];
                        $nombrePDF=$nomCurso.$this->infoTipoImagen('archivo')[1];

                        //Recuperar valores encviados
                        $tc = $request->get("tc");
                        $nom_cur = $request->get("nombrecurso");
                        $can_alum = $request->get("cant_alum");
                        $des_info = $request->get("des_info");
                        $nun_cuo = $request->get("nun_cuo");
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

                        //Persistir
                        $em->persist($curso);

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
                        return $this->render("AppBundle:Secretaria/HorarioCurso:hc_create.html.twig",array("id"=>$idcurso,"nom"=>$nom_cur));
                    }
                }
                else
                    return new Response('El Archivo no es una imagen o un PDF. Intente de nuevo!');
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

        $doc=$this->mostrarCursos();

        $tc=$em->getRepository("AppBundle:TipoCurso")->findAll();
        $datos=$em->getRepository('AppBundle:Curso')->find($id);

        //Verificando que hay una peticion POST
        if($request->isMethod("POST")) {

            if ($_FILES["imagen"]["error"] > 0 && $_FILES["archivo"]["error"] > 0)
                return new Response('Error en subida de Imagen o del PDF');

            else {
                if($this->infoTipoImagen('imagen')[0]=='image' && $this->infoTipoImagen('archivo')[0]=='application')
                {
                    $nomCurso=$request->get('nombrecurso');
                    $nombreImagen=$nomCurso.$this->infoTipoImagen('imagen')[1];
                    $nombrePDF=$nomCurso.$this->infoTipoImagen('archivo')[1];

                    //Recuperar valores encviados
                    $tc = $request->get("tc");
                    $nom_cur = $request->get("nombrecurso");
                    $can_alum = $request->get("cant_alum");
                    $des_info = $request->get("des_info");
                    $nun_cuo = $request->get("nun_cuo");
                    $array_doc = $request->get("doc");

                    $a=$this->IdCurso($id);
                    $hc=$em->getRepository("AppBundle:HorarioCurso")->find($a);

                    //Proceso de almacenamiento edicion de datos en entidad Curso
                    $datos->setIdTc($em->getRepository("AppBundle:TipoCurso")->find($tc));
                    $datos->setNombreCurso($nom_cur);
                    $datos->setCantAlumnosLimit($can_alum);
                    $datos->setTextoInformativo($des_info);
                    $datos->setBroshureInformativo("img/brochure/".$nombreImagen);
                    $datos->setNumCuotas($nun_cuo);
                    $datos->setRutaPdf("img/pdf/".$nombrePDF);

                    //Guradar en la BD
                    $em->flush();

                    //Subiendo la Imagen
                    $this->subirImagen('imagen',$nombreImagen);
                    //Subiendo el PDF
                    $this->subirPDF('archivo',$nombrePDF);

                    $this->del_d1($id);


                    //Manejando relacion de muchos a muchos
                    for ($i = 0; $i < count($array_doc); $i++) {

                        $this->manytomany($id,$array_doc[$i]);

                    }

                    return $this->render("AppBundle:Admin/HorarioCurso:hc_edit.html.twig",array("id"=>$id,"nom"=>$nom_cur,"hc"=>$hc));
                }
                else
                    return new Response('El Archivo no es una imagen o un PDF. Intente de nuevo!');
            }
        }

        return $this->render("AppBundle:Secretari/Curso:curso_edit.html.twig",array("tc"=>$tc,'datos'=>$datos,"doc"=>$doc));
    }


    /**
     * @Route("/secretaria/curso_delete/{idcurso}",name="delCurso")
     */
    public function deleteAction($idcurso, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $curso=$em->getRepository('AppBundle:Curso')->find($idcurso);
        if(!$curso){
            throw $this->createNotFoundException('No existe el usuario con el ID'.$idcurso);
        }

        $a=$this->IdCurso($idcurso);

        $sql="select broshure_informativo from curso where id_curso=$a";
        $con=$em->getConnection();
        $st=$con->prepare($sql);
        $st->execute();
        $nombreImagen = $st->fetch();

        foreach ($nombreImagen as $nombreImagen){
            $a1=$nombreImagen;
        }

        $sql="select ruta_pdf from curso where id_curso=$a";
        $con=$em->getConnection();
        $st=$con->prepare($sql);
        $st->execute();
        $nombrePDF = $st->fetch();

        foreach ($nombrePDF as $nombrePDF){
            $a2=$nombrePDF;
        }

        $this->borrarImagen($a1);
        $this->borrarPDF($a2);

        $this->del_d1($idcurso);

        $em->remove($curso);
        $em->flush();

        $sql="delete from horario_curso where id_hc=$a";
        $con=$em->getConnection();
        $st=$con->prepare($sql);
        $st->execute();



        $this->MensajeFlash('exito','Curso Eliminado correctamente');

        return $this->redirectToRoute("verCurso");
    }

     /**
     * @Route("/secretaria/curso_horario",name="addHorario")
     */
    public function horarioAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        if($request->isMethod("POST")) {

            $hc=new HorarioCurso();

            //Recuperar valores encviados y seteandolos
            $hc->setFechaInicio(new \DateTime($request->get("fechaini")));
            $hc->setFechaFin(new \DateTime($request->get("fechafin")));
            $hc->setInicioRecepDoc(new \DateTime($request->get("fechainirec")));
            $hc->setFinRecepDoc(new \DateTime($request->get("fechafinrec")));

            //Persistir
            $em->persist($hc);
            //Guradar en la BD
            $em->flush();

            $this->updateCurso($hc->getIdHc(),$request->get("idCurso"));

            $this->MensajeFlash('exito','Curso creado correctamente!');

            return $this->redirectToRoute("verCurso");
        }
    }

    /**
     * @Route("/secretaria/curso_horario_edit",name="editHorario")
     */
    public function edithorarioAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        if($request->isMethod("POST")) {

            $idCurso=$request->get("idCurso");

            $a=$this->IdCurso($idCurso);

            $hc=$em->getRepository('AppBundle:HorarioCurso')->find($a);

            //Recuperar valores encviados y seteandolos
            $hc->setFechaInicio(new \DateTime($request->get("fechaini")));
            $hc->setFechaFin(new \DateTime($request->get("fechafin")));
            $hc->setInicioRecepDoc(new \DateTime($request->get("fechainirec")));
            $hc->setFinRecepDoc(new \DateTime($request->get("fechafinrec")));

            //Guradar en la BD
            $em->flush();

            $this->MensajeFlash('exito','Curso editado correctamente!');

            return $this->redirectToRoute("verCurso");
        }
    }
}