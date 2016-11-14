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

class HorarioEntrevistaController extends DSIController
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
    public function createEntrevistaAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager("default");
        $curso=$em->getRepository('AppBundle:Curso')->findBy(array("estadoCurso"=>"registro"));
        //Verificando que hay una peticion POST
        if($request->isMethod("POST")) {
            //Recuperar y seteando valores enviados
            $he = new HorarioEntrevista();
            $he->setIdCurso($em->getRepository("AppBundle:Curso")->find($request->get("curso")));
            $he->setFechaDhe(new \DateTime($request->get("fecha")));
            $hora=(new \DateTime($request->get("hora")));

            $he->setHoraDhe($hora);
            $he->setOcupado(false);
            $he->setTipoHorario('cita');
            //Persistir
            $em->persist($he);

            //Guradar en la BD
            $em->flush();
            $this->MensajeFlash('exito','Horario de Entrevista creado correctamente!');
            return $this->redirectToRoute("verEntrevista");
        }
        return $this->render("AppBundle:Secretaria/HorarioEntrevista:HE_create.html.twig", array("curso"=>$curso));

    }

    /**
     * @Route("/secretaria/HEntrevista_edit/{id}",name="editEntrevista")
     */
    public function editEntrevistaAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $he=$em->getRepository('AppBundle:HorarioEntrevista')->find($id);
        $curso=$em->getRepository('AppBundle:Curso')->findAll();

        //Verificando que hay una peticion POST
        if($request->isMethod("POST")) {
            //Recuperar y seteando valores enviados

            //$he->setIdCurso($em->getRepository("AppBundle:Curso")->find($request->get("curso")));
            $he->setFechaDhe(new \DateTime($request->get("fecha")));
            $hora=(new \DateTime($request->get("hora")));
            $he->setHoraDhe($hora);
            $he->setTipoHorario($request->get("tipoH"));

            //Guardar en la BD
            $em->flush();

            $this->MensajeFlash('exito','Horario de Entrevista editado correctamente!');
            return $this->redirectToRoute("verEntrevista");
        }

        return $this->render("AppBundle:Secretaria/HorarioEntrevista:HE_edit.html.twig", array("he"=>$he,"curso"=>$curso));
    }

    /**
     * @Route("/secretaria/HEntrevista_del/{id}",name="delEntrevista")
     */
    public function delEntrevistaAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $he=$em->getRepository('AppBundle:HorarioEntrevista')->find($id);
        $em->remove($he);
        $em->flush();
        $this->MensajeFlash('exito','Horario de Entrevista Eliminado correctamente!');
        return $this->redirectToRoute("verEntrevista");
    }
}

