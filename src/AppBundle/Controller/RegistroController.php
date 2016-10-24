<?php

namespace AppBundle\Controller;

use AppBundle\Controller\SecurityController;
use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistroController extends SecurityController
{

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request){
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager("default");
            //Creando usuario
            $u = new Usuario();
            $u->setNomusuario($request->get("usuario"));
            $u->setNombre($request->get("nombre"));
            //interesado = 4
            $u->setIdRol($em->getRepository('AppBundle:Roles')->find('4'));
            $u->setCorreo($request->get("email"));
            $u->setApellido($request->get("apellido"));
            $u->setIsactive(1);
            //Verificar que no exista el usuario
            $qbu = $em->getRepository('AppBundle:Usuario')->createQueryBuilder('usr');
            $qbu->select('COUNT(usr)');
            $qbu->where('usr.nomusuario = :u');
            $qbu->setParameter('u',$request->get("usuario"));
            $countu = $qbu->getQuery()->getSingleScalarResult();
            //Verificar que no exista el correo
            $qbc = $em->getRepository('AppBundle:Usuario')->createQueryBuilder('usr');
            $qbc->select('COUNT(usr)');
            $qbc->where('usr.correo = :c');
            $qbc->setParameter('c',$request->get("email"));
            $countc = $qbc->getQuery()->getSingleScalarResult();
            if (0 == $countu) {
                if (0 == $countc) {
                    //Cifra la contrase?a
                    $factory = $this->get('security.encoder_factory');
                    $encoder = $factory->getEncoder($u);
                    $password = $encoder->encodePassword($request->get("password"), $u->getSalt());
                    $u->setPassword($password);
                    //Persistencia
                    $em->persist($u);
                    $em->flush();
                    $this->MensajeFlash('exito', 'Registro completado, ya puede iniciar sesión.');
                    //redireccionamiento
                    return $this->redirectToRoute('login');
                }else {
                    $this->MensajeFlash('error', 'El correo ya se esta usando, ingrese nuevamente su correo.');
                    $error = 'El correo ya se esta usando, ingrese nuevamente su correo';
                    return $this->render(':login:registro.html.twig', array('interesado' => $u, 'error' => $error));
                }
            }else{
                $this->MensajeFlash('error','El usuario ya se esta usando, ingrese un nuevo usuario.');
                $error = 'El usuario ya se esta usando, ingrese un nuevo usuario';
                return $this->render(':login:registro.html.twig', array('interesado' => $u,'error' => $error));
            }
        }else {
            $interesado = new Usuario();
            $error = '';
            return $this->render(':login:registro.html.twig', array('interesado' => $interesado,'error' => $error));
        }
    }

    /**
     * @Route("/register/create", name="register_create")
     */
    public function registerCreateAction(){
        $interesado = new Usuario();
        return $this->render(':login:registro.html.twig',array('interesado' => $interesado));
    }
}
