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
     * @Route("/prueba", name="Prueba")
     */
    /*
    public function pruebaAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager("default");
        //Creando usuario
        $u = new Usuario();
        $u->setNomusuario("meom");
        $u->setIdtipousuario($em->getRepository('AppBundle:Tipousuario')->find(1));
        //Cifra la contrase?a
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($u);
        $password = $encoder->encodePassword("12345", $u->getSalt());
        $u->setPassword($password);
        $u->setIsactive(1);
        //Persistencia
        $em->persist($u);
        $em->flush();
        //redireccionamiento
        //return new Response("Insertado");
        echo 'Insertado';
        die();
    }*/

    /**
     * @Route("/admin/tipo_curso/create", name="creartipocurso")
     */
    public function adminAction(){
        return $this->render('AppBundle:Admin:tipo_curso.html.twig');
    }
    /**
     * @Route("/admin/funcion", name="funcion")
     */
    public function funcionAction(){
        return $this->render(':default:funcion.html.twig');
    }

    /**
     * @Route("/admin/form", name="funcion")
     */
    public function formAction(){
        return $this->render('AppBundle:Admin:formularios.html.twig');
    }
    /**
     * @Route("/admin/tipo", name="tipo")
     */
    public function tipocursoAction(){
        return $this->render('AppBundle:Admin:tipo_curso.html.twig');
    }

}
