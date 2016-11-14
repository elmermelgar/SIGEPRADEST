<?php

namespace AppBundle\Controller\Director;

use AppBundle\Controller\DSIController;
use AppBundle\Entity\Solicitud;
use AppBundle\Tests\Controller\DetalleCursoControllerTest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

class SolicitudDiController extends DSIController
{
    /**
     * @route("/director/sol",name="verSol(dir)")
     */
    public function verSolDirAction()
    {
        if($this->getUser()){
            $em=$this->getDoctrine()->getManager("default");
            $sol=$em->getRepository('AppBundle:Solicitud')->findBy(array("estado"=>"evaluacion"));
            $usu=$em->getRepository('AppBundle:Usuario')->findAll();
            $dp=$em->getRepository('AppBundle:DatosPersonales')->findAll();
            $cur=$em->getRepository('AppBundle:Curso')->findAll();

            return $this->render('AppBundle:Director/Solicitud(eva):Sol.html.twig', array('sol'=>$sol,'usu'=>$usu,'dp'=>$dp,'cur'=>$cur));
        }else{
            return $this->redirectToRoute('login');
        }
    }
    /**
     * @route("/director/sol_aprobar/{id}",name="aprobarSol")
     */
    public function aprobarSolAtion($id)
    {
        $em=$this->getDoctrine()->getManager("default");
        $sol=$em->getRepository('AppBundle:Solicitud')->find($id);
        $sol->setEstado('aprobada');
        //Guardar en la BD
        $em->flush();

        return $this->redirectToRoute('verSol(dir)');
    }

    /**
     * @route("/director/sol_denegar/{id}",name="denagarSol")
     */
    public function denegarSolAtion($id)
    {
        $em=$this->getDoctrine()->getManager("default");
        $sol=$em->getRepository('AppBundle:Solicitud')->find($id);
        $sol->setEstado('denegada');
        //Guardar en la BD
        $em->flush();

        return $this->redirectToRoute('verSol(dir)');
    }

}
