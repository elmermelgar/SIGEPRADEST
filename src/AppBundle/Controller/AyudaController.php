<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Usuario;

class AyudaController extends SecurityController
{

    // Para los metodo de ayuda
    /**
     * @Route("/admin/ayuda", name="adminAyuda")
     */
    public function adminAyudaAction(){
        return $this->render('AppBundle:Ayuda:AdministradorAyuda.html.twig');
    }

    /**
     * @Route("/interesado/ayuda", name="interesadoAyuda")
     */
    public function interesadoAyudaAction(){
        return $this->render('AppBundle:Ayuda:interesadosAyuda.html.twig');
    }

    /**
     * @Route("/tutor/ayuda", name="tutorAyuda")
     */
    public function tutorAyudaAction(){
        return $this->render('AppBundle:Ayuda:tutorAyuda.html.twig');
    }

    /**
     * @Route("/alumno/ayuda", name="alumnoAyuda")
     */
    public function alumnoAyudaAction(){
        return $this->render('AppBundle:Ayuda:alumnoAyuda.html.twig');
    }

    /**
     * @Route("/director/ayuda", name="directorAyuda")
     */
    public function directorAyudaAction(){
        return $this->render('AppBundle:Ayuda:directorAyuda.html.twig');
    }

    /**
     * @Route("/secretaria/ayuda", name="secretariaAyuda")
     */
    public function secretariaAyudaAction(){
        return $this->render('AppBundle:Ayuda:secretariaAyuda.html.twig');
    }
    
}