<?php

namespace AppBundle\Controller\Secretaria;

use AppBundle\Controller\DSIController;
use AppBundle\Entity\Solicitud;
use AppBundle\Tests\Controller\DetalleCursoControllerTest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

class SolicitudSecreController extends DSIController
{
    /**
     * @route("/secretaria/sol",name="verSol(sec)")
     */
    public function verSolSecAction()
    {
        if($this->getUser()){
            $em=$this->getDoctrine()->getManager("default");
            $sol=$em->getRepository('AppBundle:Solicitud')->findBy(array("estado"=>"enviada"));
            $usu=$em->getRepository('AppBundle:Usuario')->findAll();
            $dp=$em->getRepository('AppBundle:DatosPersonales')->findAll();
            $cur=$em->getRepository('AppBundle:Curso')->findAll();

            return $this->render('AppBundle:Secretaria/Solicitud(env):Sol.html.twig', array('sol'=>$sol,'usu'=>$usu,'dp'=>$dp,'cur'=>$cur));
        }else{
            return $this->redirectToRoute('login');
        }
    }
}
