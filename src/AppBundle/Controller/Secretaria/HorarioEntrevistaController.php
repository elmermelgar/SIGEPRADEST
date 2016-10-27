<?php

namespace AppBundle\Controller\Secretaria;

use AppBundle\Controller\DSIController;
use AppBundle\Entity\HorarioEntrevista;
use AppBundle\Tests\Controller\DetalleCursoControllerTest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

class HorarioEntrevistaController extends Controller
{
    /**
     * @Route("/secretaria/HEntrevista",name="verEntrevista")
     */
    public function verEntrevistaAction()
    {
        if($this->getUser()){
            $em=$this->getDoctrine()->getManager("default");
            $he=$em->getRepository('AppBundle:HorarioEntrevista')->findAll();

            return $this->render('AppBundle:Secretaria/HorarioEntrevista:HE.html.twig', array('he'=>$he));
        }else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/secretaria/HEntrevista_create",name="createEntrevista")
     */
    public function createEntrevista(Request $request)
    {
        $em=$this->getDoctrine()->getManager("default");
        $curso=$em->getRepository('AppBundle:Curso')->findBy(array("estadoCurso"=>"Registro"));
        //Verificando que hay una peticion POST
        if($request->isMethod("POST")) {
            //Recuperar y seteando valores enviados
            $HC = new HorarioEntrevista();

            $HC->setIdCurso($em->getRepository("AppBundle:Curso")->find($request->get("curso")));
            $HC->setFechaDhe(new \DateTime($request->get("fecha")));
            $hora=(new \DateTime($request->get("hora")));
          /*  var_dump($hora);
            die();*/

            $HC->setHoraDhe($hora);
            $HC->setOcupado(false);
            $HC->setTipoHorario($request->get("tipoH"));
            //Persistir
            $em->persist($HC);

            //Guradar en la BD
            $em->flush();
            return $this->redirectToRoute("verEntrevista");
        }
        return $this->render("AppBundle:Secretaria/HorarioEntrevista:HE_create.html.twig", array("curso"=>$curso));

    }
}

