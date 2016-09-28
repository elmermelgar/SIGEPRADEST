<?php

namespace AppBundle\Controller\Admin;

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
     * @Route("/admin/cursos",name="verCurso")
     */
    public function verCursoAction()
    {
        $em=$this->getDoctrine()->getManager("default");
        $cursos=$em->getRepository('AppBundle:Curso')->findAll();
        return $this->render('AppBundle:Admin/Curso:curso.html.twig', array('cursos'=>$cursos));
    }

    /**
     * @Route("/admin/curso_create",name="createCurso")
     */
    public function createCursoAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $tc=$em->getRepository("AppBundle:TipoCurso")->findAll();

        $db = $em->getConnection();
        $sql = "SELECT * FROM doctores";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $doc = $stmt->fetchAll();

        //Verificando que hay una peticion POST
        if($request->isMethod("POST")) {
            if ($_FILES["imagen"]["error"] > 0 && $_FILES["archivo"]["error"] > 0)
                return new Response('Error en subida de Imagen o de PDF');

            else {
                if($this->infoTipoImagen('imagen')[0]=='image' && $this->infoTipoImagen('archivo')[0]=='application')
                //if($this->infoTipoImagen('imagen')[0]=='application')
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
                            $sql="INSERT INTO d1 (id_curso,id_doctores) values (:id_curso,:id_doctores)";
                            $em=$this->getDoctrine()->getEntityManager();
                            $con=$em->getConnection();
                            $st=$con->prepare($sql);
                            $st->bindValue("id_curso",$idcurso);
                            $st->bindValue("id_doctores",$array_doc[$i]);
                            $st->execute();
                        }

                        return $this->render("AppBundle:Admin/HorarioCurso:hc_create.html.twig",array("id"=>$idcurso,"nom"=>$nom_cur));
                    }
                }
                else
                    return new Response('El Archivo no es una imagen o un PDF. Intente de nuevo!');
            }
        }

        return $this->render("AppBundle:Admin/Curso:curso_create.html.twig",array("tc"=>$tc,"doc"=>$doc));
    }

    /**
     * @Route("/admin/curso_edit/{id}",name="editCurso")
     */
    public function editCursoAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        $db = $em->getConnection();
        $sql = "SELECT * FROM doctores";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $doc = $stmt->fetchAll();

        //Sacando Id_hc con ayuda del IdCurso
        $db = $em->getConnection();
        $sql = "select id_hc from horario_curso where id_hc = (select id_hc from curso where id_curso=$id) ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $idhc = $stmt->fetch();

        $tc=$em->getRepository("AppBundle:TipoCurso")->findAll();
        $datos=$em->getRepository('AppBundle:Curso')->find($id);

        //Verificando que hay una peticion POST
        if($request->isMethod("POST")) {

            if ($_FILES["imagen"]["error"] > 0 && $_FILES["archivo"]["error"] > 0)
                return new Response('Error en subida de Imagen o del PDF');

            /*if ($_FILES["archivo"]["error"] > 0)
                return new Response('Error en subida de PDF');*/

            else {
                if($this->infoTipoImagen('imagen')[0]=='image' && $this->infoTipoImagen('archivo')[0]=='application')
                    //if($this->infoTipoImagen('imagen')[0]=='application')
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

                    //Descomponiendo el array
                    foreach ($idhc as $idhc){
                        $a=$idhc;
                    }

                    //Proceso de almacenamiento edicion de datos en entidad Curso
                    $hc=$em->getRepository("AppBundle:HorarioCurso")->find($a);

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

                    $sql="delete from d1 where id_curso=$id";
                    $em=$this->getDoctrine()->getEntityManager();
                    $con=$em->getConnection();
                    $st=$con->prepare($sql);
                    $st->execute();


                    //Manejando relacion de muchos a muchos
                    for ($i = 0; $i < count($array_doc); $i++) {
                        $sql="INSERT INTO d1 (id_curso,id_doctores) values (:id_curso,:id_doctores)";
                        $em=$this->getDoctrine()->getEntityManager();
                        $con=$em->getConnection();
                        $st=$con->prepare($sql);
                        $st->bindValue("id_curso",$id);
                        $st->bindValue("id_doctores",$array_doc[$i]);
                        $st->execute();

                    }

                    return $this->render("AppBundle:Admin/HorarioCurso:hc_edit.html.twig",array("id"=>$id,"nom"=>$nom_cur,"hc"=>$hc));
                }
                else
                    return new Response('El Archivo no es una imagen o un PDF. Intente de nuevo!');
            }
        }

        return $this->render("AppBundle:Admin/Curso:curso_edit.html.twig",array("tc"=>$tc,'datos'=>$datos,"doc"=>$doc));
    }


    /**
     * @Route("/admin/curso_delete",name="delCurso")
     */
    public function deleteAction($idcurso, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $curso=$em->getRepository('AppBundle:Curso')->find($idcurso);
        if(!$curso){
            throw $this->createNotFoundException('No existe el usuario con el ID'.$idcurso);
        }
       /* if($em->getRepository('toosistemadeventasBundle:Producto')->findOneBy(array('idCategoria'=>$idCat))){
            $this->MensajeFlash('fracaso','No puede eliminar una Categoria que ya contiene productos');
            return $this->redirect($this->generateUrl('crudCat'));
        }*/
        else{
            $em->remove($curso);
            $em->flush();
            $this->MensajeFlash('exito','Curso Eliminado correctamente');
            return $this->redirectToRoute("ver");
        }

    }

     /**
     * @Route("/admin/curso_horario",name="addHorario")
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

            return $this->redirectToRoute("verCurso");
        }
    }

    /**
     * @Route("/admin/curso_horario_edit",name="editHorario")
     */
    public function edithorarioAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        if($request->isMethod("POST")) {

            //Sacando Id_hc con ayuda del IdCurso
            $db = $em->getConnection();
            $sql = "select id_hc from horario_curso where id_hc = (select id_hc from curso where id_curso=:idCurso) ";
            $stmt = $db->prepare($sql);
            $stmt->bindValue("idCurso",$request->get("idCurso"));
            $stmt->execute();
            $idhc = $stmt->fetch();

            foreach ($idhc as $idhc){
                $a=$idhc;
            }

            $hc=$em->getRepository('AppBundle:HorarioCurso')->find($a);

            //Recuperar valores encviados y seteandolos
            $hc->setFechaInicio(new \DateTime($request->get("fechaini")));
            $hc->setFechaFin(new \DateTime($request->get("fechafin")));
            $hc->setInicioRecepDoc(new \DateTime($request->get("fechainirec")));
            $hc->setFinRecepDoc(new \DateTime($request->get("fechafinrec")));

            //Guradar en la BD
            $em->flush();

            //$this->updateCurso($hc->getIdHc(),$request->get("idCurso"));

            return $this->redirectToRoute("verCurso");
        }
    }
}