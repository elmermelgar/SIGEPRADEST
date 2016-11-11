<?php

namespace AppBundle\Controller\Tutor;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\SecurityController;

class ModulosController extends SecurityController
{

    //Metodo para cambiar el password del tutor
    /**
     * @Route("/tutor/cambiarpass/{id}", name="cambiar_pass_tutor")
     */
    public function cambiarPassAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $datos=$this->getDoctrine()->getRepository('AppBundle:Usuario')->find($id);
        if($request->isMethod("POST"))
        {

            //Cifra el password
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($datos);
            $password = $encoder->encodePassword($request->get("pass"), $datos->getSalt());
            $datos->setPassword($password);
            $em->flush();
            //redireccionamiento
            $this->MensajeFlash('exito','Se actualizo la contraseña correctamente!');
            return $this->redirect($this->generateUrl('tutor'));
        }
        return $this->render('AppBundle:Tutor/Modulos:cambiar_password_tutor.html.twig');
    }

}
