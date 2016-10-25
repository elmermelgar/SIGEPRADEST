<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Usuario;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="index")
     */
    public function indexAction(){
        return $this->render('AppBundle:Principal:index.html.twig');
    }

    /**
     * @Route("/sql",name="sql")
     */
    public function sqlAction(){
        $em=$this->getDoctrine()->getEntityManager('default');
        $db = $em->getConnection();

        //$sql = "SELECT * FROM empleados";
        $sql = "SELECT * FROM usuario";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        //var_dump($result[0]["nomusuario"]);
        foreach($result as $r){
            echo $r["nomusuario"]."<br>";
        }
        die();
    }
    /**
     * @Route("/admin/form", name="funcion")
     */
    public function formAction(){
        return $this->render('AppBundle:Admin:formularios.html.twig');
    }
}
