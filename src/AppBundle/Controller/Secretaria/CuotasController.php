<?php

namespace AppBundle\Controller\Secretaria;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\SecurityController;

class CuotasController extends SecurityController
{
    /**
     * @Route("/secretaria/cuotas/{id}", name="cuotas")
     */
    public function cuotasViewsAction($id,Request $request){
        if($this->getUser()){
            $em2=$this->getDoctrine()->getManager("default");
            $cuotas=$em2->getRepository('AppBundle:Cuotas')->findBy('id_curso',$id);
            return $this->render('AppBundle:Admin/Doctores:doctores_views.html.twig', array('doctores'=>$doctores));
        }
        else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/secretaria/cursosCuotas/", name="cursoscuotas")
     */
    public function cursosCuotasViewsAction(Request $request){
        if($this->getUser()){
            $em2=$this->getDoctrine()->getManager("default");
            $cursos=$em2->getRepository('AppBundle:Curso')->findAll();
            return $this->render('AppBundle:Secretaria/Cuotas:curso.html.twig', array('cursos'=>$cursos));
        }
        else{
            return $this->redirectToRoute('login');
        }
    }

}
