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
        $hc=$em->getRepository("AppBundle:HorarioCurso")->findAll();
        $tc=$em->getRepository("AppBundle:TipoCurso")->findAll();
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

                    if($em->getRepository('AppBundle:Curso')->findOneBy(array('nombreCurso'=>$nomCurso)))
                    {
                        return new Response("El Curso ya ha sido registrado!");
                    }
                    else {
                        $nombreImagen=$nomCurso.$this->infoTipoImagen('imagen')[1];
                        $nombrePDF=$nomCurso.$this->infoTipoImagen('archivo')[1];

                        //Recuperar valores encviados
                        $hc = $request->get("hc");
                        $tc = $request->get("tc");
                        $nom_cur = $request->get("nombrecurso");
                        $can_alum = $request->get("cant_alum");
                        $des_info = $request->get("des_info");
                        //$bros_info = $request->get("imagen");
                        $nun_cuo = $request->get("nun_cuo");
                        //$ruta = $request->get("archivo");

                        //Proceso de almacenamiento de datos en entidad Curso
                        $curso=new Curso();
                        $curso->setIdHc($em->getRepository("AppBundle:HorarioCurso")->find($hc));
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
                        return new Response("Curso creado correctamente!");
                    }
                }
                else
                    return new Response('El Archivo no es una imagen. Intente de nuevo!');
            }
        }

        return $this->render("AppBundle:Admin/Curso:curso_create.html.twig",array("hc"=>$hc,"tc"=>$tc));
    }

    /**
     * @Route("/admin/curso_edit/{id}",name="editCurso")
     */
    public function editCursoAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $hc=$em->getRepository("AppBundle:HorarioCurso")->findAll();
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

                    if($em->getRepository('AppBundle:Curso')->findOneBy(array('nombreCurso'=>$nomCurso)))
                    {
                        return new Response("El Curso ya ha sido registrado!");
                    }
                    else {
                        $nombreImagen=$nomCurso.$this->infoTipoImagen('imagen')[1];
                        $nombrePDF=$nomCurso.$this->infoTipoImagen('archivo')[1];

                        //Recuperar valores encviados
                        $hc = $request->get("hc");
                        $tc = $request->get("tc");
                        $nom_cur = $request->get("nombrecurso");
                        $can_alum = $request->get("cant_alum");
                        $des_info = $request->get("des_info");
                        //$bros_info = $request->get("imagen");
                        $nun_cuo = $request->get("nun_cuo");
                        //$ruta = $request->get("archivo");

                        //Proceso de almacenamiento edicion de datos en entidad Curso

                        $datos->setIdHc($em->getRepository("AppBundle:HorarioCurso")->find($hc));
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
                        return new Response("Curso Editado Perfectamente!");
                    }
                }
                else
                    return new Response('El Archivo no es una imagen. Intente de nuevo!');
            }
        }

        return $this->render("AppBundle:Admin/Curso:curso_edit.html.twig",array("hc"=>$hc,"tc"=>$tc,'datos'=>$datos));
    }


    /**
     * @Route("/admin/curso_delete",name="delete")
     */
    public  function deleteAction($idcurso, Request $request)
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

}