<?php

namespace AppBundle\Controller\Director;

use AppBundle\Entity\Doctores;
use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\SecurityController;

class Usuarios2Controller extends SecurityController
{

    /**
     * @Route("/director/usuario/create", name="nuevo_usuario2")
     */
    public function nuevoUsuarioAction(Request $request)
    {
        $em2 = $this->getDoctrine()->getManager("default");
        $usu = $em2->getRepository('AppBundle:Usuario')->findOneBy(array('nomusuario' => $request->get("username")));
        if ($usu) {
            $this->MensajeFlash('error', 'El usuario ya existe. No puede crear usuarios repetidos!');
            $em2 = $this->getDoctrine()->getManager("default");
            $usuarios = $em2->getRepository('AppBundle:Usuario')->findAll();
            return $this->redirect($this->generateUrl('usuarios2', array('usuarios' => $usuarios)));
        } else {
            if ($request->isMethod("POST")) {
                $existe = $em2->getRepository('AppBundle:Usuario')->findOneBy(array('nomusuario' => $request->get("username")));
                $email = $em2->getRepository('AppBundle:Usuario')->findOneBy(array('correo' => $request->get("email")));
                if ($existe or $email) {
                    $this->MensajeFlash('error', 'El nombre de usuario o correo ya existe!');
                    $em2 = $this->getDoctrine()->getManager("default");
                    $usuarios = $em2->getRepository('AppBundle:Usuario')->findAll();
                    return $this->redirect($this->generateUrl('usuarios2', array('usuarios' => $usuarios)));
                } else {
                    //Creando usuario
                    $u = new Usuario();
                    $u->setNomusuario($request->get("username"));
                    $u->setNombre($request->get("nombre"));
                    $usuario = $request->get("username");
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
                    //Creando un tutor a partir de un Usuario de tipo tutor
                    $tutor = $em2->getRepository('AppBundle:Usuario')->findOneBy(array('nomusuario' => $usuario));
                    $doc = new Doctores();
                    $doc->setNombreDoc($request->get("nombre"));
                    $doc->setApellidoDoc($request->get("apellido"));
                    $doc->setDuiDoc($request->get("id_emp"));
                    $doc->setEspecialidad($request->get("especialidad"));
                    $doc->setTurno($request->get("turno"));
                    $usu = $em2->getRepository('AppBundle:Usuario')->find($tutor->getIdUi());
                    $doc->setIdUi($usu);
                    $em2->persist($doc);
                    $em2->flush();
                    //redireccionamiento
                    $this->MensajeFlash('exito', 'Usuario creado correctamente!');

                    $em2 = $this->getDoctrine()->getManager("default");
                    $usuarios = $em2->getRepository('AppBundle:Usuario')->findAll();
                    return $this->redirect($this->generateUrl('usuarios2', array('usuarios' => $usuarios)));
                }

            }
        }
        return $this->render('AppBundle:Director/Usuarios2:nuevo_usuario.html.twig');
    }

    /**
     * @Route("/director/usuario/{id}/edit", name="editar_usuario2")
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
        return $this->render('AppBundle:Director/Usuarios2:editar_usuario.html.twig', array(
            'usuario' => $datos));
    }

    /**
     * @Route("/director/usuarios/", name="usuarios2")
     */
    public function usuariosViewsAction(Request $request){
        if($this->getUser()){
            $em=$this->getDoctrine()->getManager();
            $usuarios=$em->getRepository('AppBundle:Usuario')->findAll();
            return $this->render('AppBundle:Director/Usuarios2:usuarios_views.html.twig', array('usuarios'=>$usuarios));
        }
        else{
            return $this->redirectToRoute('login');
        }
    }
    /**
     * @Route("/director/usuario/delete/{id}", name="eliminar_usuario2")
     */
    public function deleteUsuarioAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $usuario=$em->getRepository('AppBundle:Usuario')->find($id);
        if(!$usuario){
            throw $this->createNotFoundException('No existe el usuario con el ID'.$id);
        }
        $usuario->setIsactive(0);
        $em->flush();
        $this->MensajeFlash('exito','Usuario desactivado correctamente!');
        return $this->redirectToRoute("usuarios2");
    }

    //Metodo para cambiar el password del director
    /**
     * @Route("/director/cambiarpass/{id}", name="cambiar_pass_director")
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
            return $this->redirect($this->generateUrl('director'));
        }
        return $this->render('AppBundle:Director/Usuarios2:cambiar_password_director.html.twig');
    }

}
