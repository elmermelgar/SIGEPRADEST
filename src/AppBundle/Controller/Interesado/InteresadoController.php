<?php

namespace AppBundle\Controller\Interesado;

use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InteresadoController extends Controller
{
    /**
     * @Route("/interesado/register", name="register")
     */
    public function registerAction(Request $request){
        if ($request->isMethod('POST'))
        {
            $em=$this->getDoctrine()->getManager("default");
            //Creando usuario
            $u = new Usuario();
            $u->setNomusuario($request->get("usuario"));
            $u->setNombre($request->get("nombre"));
            //interesado = 4
            $u->setIdRol($em->getRepository('AppBundle:Roles')->find('4'));
            $u->setCorreo($request->get("email"));
            $u->setApellido($request->get("apellido"));
            $u->setIsactive(1);
            //Cifra la contrase?a
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($u);
            $password = $encoder->encodePassword($request->get("password"), $u->getSalt());
            $u->setPassword($password);
            //Persistencia
            $em->persist($u);
            $em->flush();
            //redireccionamiento
            return $this->redirectToRoute('interesado');
        }else {
            $interesado = new Usuario();
            return $this->render('AppBundle:Interesado:registro.html.twig', array('interesado' => $interesado));
        }
    }

    /**
     * @Route("/interesado/register/create", name="register_create")
     */
    public function registerCreateAction(){
        $interesado = new Usuario();
        return $this->render('AppBundle:Interesado:registro.html.twig',array('interesado' => $interesado));
    }


}
