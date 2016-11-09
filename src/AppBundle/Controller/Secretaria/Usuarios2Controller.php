<?php

namespace AppBundle\Controller\Secretaria;

use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\SecurityController;

class Usuarios2Controller extends SecurityController
{

    /**
     * @Route("/secretaria/usuario/create", name="nuevo_usuario2")
     */
    public function nuevoUsuarioAction(Request $request){
        $em2=$this->getDoctrine()->getManager("default");

        if($request->isMethod("POST"))
        {
            $existe=$em2->getRepository('AppBundle:Usuario')->findOneBy(array('nomusuario' => $request->get("username")));
            $email=$em2->getRepository('AppBundle:Usuario')->findOneBy(array('correo' => $request->get("email")));
            if($existe or $email){
                $this->MensajeFlash('error','El nombre de usuario o correo ya existe!');
                $em2=$this->getDoctrine()->getManager("default");
                $usuarios=$em2->getRepository('AppBundle:Usuario')->findAll();
                return $this->redirect($this->generateUrl('usuarios2', array('usuarios'=>$usuarios)));
            }
            else{
                //Creando usuario
                $u = new Usuario();
                $u->setNomusuario($request->get("username"));
                $u->setNombre($request->get("nombre"));
                $u->setIdRol($em2->getRepository('AppBundle:Roles')->find(2));
                $u->setCorreo($request->get("email"));
                $u->setApellido($request->get("apellido"));
                $u->setTelefono($request->get("tel"));
                $u->setIdEmpleado($request->get("id_emp"));
                $u->setIsactive(1);
                //Cifra la contrasenia
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($u);
                $password = $encoder->encodePassword($request->get("pass"), $u->getSalt());
                $u->setPassword($password);
                //Persistencia
                $em2->persist($u);
                $em2->flush();
                //redireccionamiento
                $this->MensajeFlash('exito','Usuario creado correctamente!');

                $em2=$this->getDoctrine()->getManager("default");
                $usuarios=$em2->getRepository('AppBundle:Usuario')->findAll();
                return $this->redirect($this->generateUrl('usuarios2', array('usuarios'=>$usuarios)));
            }

        }
        return $this->render('AppBundle:Secretaria/Usuarios2:nuevo_usuario.html.twig');
    }

    /**
     * @Route("/secretaria/usuario/{id}/edit", name="editar_usuario2")
     */
    public function editarUsuarioAction($id, Request $request){
        $em2=$this->getDoctrine()->getManager("default");
        //Seleccionando un solo usuario";
        $datos=$this->getDoctrine()->getRepository('AppBundle:Usuario')->find($id);
        if($request->isMethod("POST"))
        {
            //$u->setNomusuario($request->get("username"));
            $datos->setNombre($request->get("nombre"));
            $datos->setIdRol($em2->getRepository('AppBundle:Roles')->find(2));
            $datos->setCorreo($request->get("email"));
            $datos->setApellido($request->get("apellido"));
            $datos->setTelefono($request->get("tel"));
            $datos->setIdEmpleado($request->get("id_emp"));
            $em2->flush();
            //redireccionamiento
            $this->MensajeFlash('exito','Usuario actualizado correctamente!');

            $em2=$this->getDoctrine()->getManager("default");
            $usuarios=$em2->getRepository('AppBundle:Usuario')->findAll();
            return $this->redirect($this->generateUrl('usuarios2', array('usuarios'=>$usuarios)));
        }
        return $this->render('AppBundle:Secretaria/Usuarios2:editar_usuario.html.twig', array(
            'usuario' => $datos));
    }

    /**
     * @Route("/secretaria/usuarios/", name="usuarios2")
     */
    public function usuariosViewsAction(Request $request){
        if($this->getUser()){
            $em=$this->getDoctrine()->getManager();
            $usuarios=$em->getRepository('AppBundle:Usuario')->findAll();
            return $this->render('AppBundle:Secretaria/Usuarios2:usuarios_views.html.twig', array('usuarios'=>$usuarios));
        }
        else{
            return $this->redirectToRoute('login');
        }
    }
    /**
     * @Route("/secretaria/usuario/delete/{id}", name="eliminar_usuario2")
     */
    public function deleteUsuarioAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $usuario=$em->getRepository('AppBundle:Usuario')->find($id);
        if(!$usuario){
            throw $this->createNotFoundException('No existe el usuario con el ID'.$id);
        }
        $em->remove($usuario);
        $em->flush();
        $this->MensajeFlash('exito','Usuario eliminado correctamente!');
        return $this->redirectToRoute("usuarios2");
    }

}
