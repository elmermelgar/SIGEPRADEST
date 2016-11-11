<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Usuario;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $error = null;

        $authenticationUtils = $this->get('security.authentication_utils');

        //obtenemos el error del login si hay alguno
        $error = $authenticationUtils->getLastAuthenticationError();

        //obtenemos el ultimo nombre de usuario ingresado
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(':login:login2.html.twig',
            array(
                'last_username' => $lastUsername,
                'error' => $error));

    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
    }

    /**
     * @Route("/index", name="control_redirect")
     */
    public function controlRedirectAction(){
        $exist=$this->getUser();
        if($exist){
            $rol=$this->getUser()->getIdrol()->getIdrol();
            if($rol==1)
                return $this->redirectToRoute('admin');
            if($rol==2)
                return $this->redirectToRoute('tutor');
            if($rol==3)
                return $this->redirectToRoute('alumno');
            if($rol==4)
                return $this->redirectToRoute('index_interesado');
            if($rol==5)
                return $this->redirectToRoute('secretaria');
            if($rol==6)
                return $this->redirectToRoute('director');
        }
        else{
            return $this->redirectToRoute('login');
        }

    }
    /**
     * @Route("/admin/", name="admin")
     */
    public function adminAction(){
        return $this->render('AppBundle:Admin:index.html.twig');
    }

    /**
     * @Route("/interesado/", name="interesado")
     */
    public function interesadoAction()
    {
        return $this->render('AppBundle:Interesado:index.html.twig');
    }
    /**
     * @Route("/tutor/", name="tutor")
     */
    public function tutorAction()
    {
        return $this->render('AppBundle:Tutor:index.html.twig');
    }
    /**
     * @Route("/alumno/", name="alumno")
     */
    public function alumnoAction()
    {
        return $this->render('AppBundle:Alumno:index.html.twig');
    }

    /**
     * @Route("/director/", name="director")
     */
    public function directorAction()
    {
        return $this->render('AppBundle:Director:index.html.twig');
    }

    /**
     * @Route("/secretaria/", name="secretaria")
     */
    public function secretariaAction()
    {
        return $this->render('AppBundle:Secretaria:index.html.twig');
    }

    //Para envio de mensajes Flash
    protected function MensajeFlash($nombre,$mensaje){
        $this->get('session')->getFlashBag()->add(
            ''.$nombre,
            ''.$mensaje
        );
    }

}
