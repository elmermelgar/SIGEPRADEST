<?php
/**
 * Created by PhpStorm.
 * User: Fernando Bolaños
 * Date: 25/10/2015
 * Time: 09:07 AM
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DSIController extends Controller
{
    //Para envio de mensajes Flash
    protected function MensajeFlash($nombre,$mensaje){
        $this->get('session')->getFlashBag()->add(
            ''.$nombre,
            ''.$mensaje
        );
    }

   //Para determinar el tipo de archivo subido
    protected function infoTipoImagen($archivo){
        $tipo=explode('/', $_FILES["".$archivo]["type"]);
        $tipo[1]='.'.$tipo[1];
        return $tipo;
    }

    //Para subir la imagen al servidor
    protected function subirImagen($archivo,$nombreImagen){
        move_uploaded_file($_FILES["".$archivo]['tmp_name'],$_SERVER['DOCUMENT_ROOT']."\\public\\img\\brochure\\".$nombreImagen);
    }

    //Para subir la PDF al servidor
    protected function subirPDF($archivo,$nombrePDF){
        move_uploaded_file($_FILES["".$archivo]['tmp_name'],$_SERVER['DOCUMENT_ROOT']."\\public\\img\\pdf\\".$nombrePDF);
    }

    protected  function updateCurso($id_hc,$id_curso){
        $sql="update curso set id_hc =:id_hc where id_curso=:id_curso";
        $em=$this->getDoctrine()->getEntityManager();
        $con=$em->getConnection();
        $st=$con->prepare($sql);
        $st->bindValue("id_hc",$id_hc);
        $st->bindValue("id_curso",$id_curso);
        $st->execute();
    }
}