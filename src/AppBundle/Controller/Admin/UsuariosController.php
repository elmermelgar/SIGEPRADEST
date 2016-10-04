<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\SecurityController;

class UsuariosController extends SecurityController
{
    /**
     * @Route("/admin/empleados", name="empleados")
     */
    public function empleadosAction(){
        if($this->getUser()){
            $em=$this->getDoctrine()->getManager("foues");
            $db = $em->getConnection();
            //$sql = "SELECT * FROM empleados";
            $sql = "SELECT * FROM empleados";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $this->render('AppBundle:Admin/Usuarios:empleados.html.twig', array(
                'empleados' => $result));
        }
        else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/admin/usuario/create/{id}", name="nuevo_usuario")
     */
    public function nuevoUsuarioAction($id, Request $request){
        $em=$this->getDoctrine()->getManager("foues");
        $em2=$this->getDoctrine()->getManager("default");
        $db = $em->getConnection();
        //$sql = "SELECT * FROM empleados";
        $sql = "SELECT * FROM empleados WHERE usuario='$id'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $ide=$id;
        if($request->isMethod("POST"))
        {
            //Creando usuario
            $u = new Usuario();
            $u->setNomusuario($request->get("username"));
            $u->setNombre($request->get("nombre"));
            $u->setIdRol($em2->getRepository('AppBundle:Roles')->find($request->get('rol')));
            $u->setCorreo($request->get("email"));
            $u->setApellido($request->get("apellido"));
            $u->setTelefono($request->get("tel"));
            $u->setIdEmpleado($request->get("id_emp"));
            $u->setIsactive(1);
            //Cifra la contrase?a
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
            return $this->redirect($this->generateUrl('usuarios', array('usuarios'=>$usuarios)));
        }
        return $this->render('AppBundle:Admin/Usuarios:nuevo_usuario.html.twig', array(
            'empleado' => $result,'ide' =>$ide));
    }

    /**
     * @Route("/admin/usuario/{id}/edit", name="editar_usuario")
     */
    public function editarUsuarioAction($id, Request $request){
        $em2=$this->getDoctrine()->getManager("default");
        //Seleccionando un solo usuario";
        $datos=$this->getDoctrine()->getRepository('AppBundle:Usuario')->find($id);
        if($request->isMethod("POST"))
        {

            //$u->setNomusuario($request->get("username"));
            $datos->setNombre($request->get("nombre"));
            $datos->setIdRol($em2->getRepository('AppBundle:Roles')->find($request->get('rol')));
            $datos->setCorreo($request->get("email"));
            $datos->setApellido($request->get("apellido"));
            $datos->setTelefono($request->get("tel"));
            //$u->setIdEmpleado($request->get("id_emp"));
           // $u->setIsactive(1);
            //Cifra la contrase?a
           // $factory = $this->get('security.encoder_factory');
            //$encoder = $factory->getEncoder($u);
           // $password = $encoder->encodePassword($request->get("pass"), $u->getSalt());
            //$u->setPassword($password);
            //Persistencia
            //$em2->persist($u);
            $em2->flush();
            //redireccionamiento
            $this->MensajeFlash('exito','Usuario actualizado correctamente!');

            $em2=$this->getDoctrine()->getManager("default");
            $usuarios=$em2->getRepository('AppBundle:Usuario')->findAll();
            return $this->redirect($this->generateUrl('usuarios', array('usuarios'=>$usuarios)));
        }
        return $this->render('AppBundle:Admin/Usuarios:editar_usuario.html.twig', array(
            'usuario' => $datos));
    }

    /**
     * @Route("/admin/usuarios/", name="usuarios")
     */
    public function usuariosViewsAction(Request $request){
        if($this->getUser()){
            $em2=$this->getDoctrine()->getManager("default");
            $usuarios=$em2->getRepository('AppBundle:Usuario')->findAll();
            return $this->render('AppBundle:Admin/Usuarios:usuarios_views.html.twig', array('usuarios'=>$usuarios));
        }
        else{
            return $this->redirectToRoute('login');
        }
    }
    /**
     * @Route("/admin/usuario/delete/{id}", name="eliminar_usuario")
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

        $em2=$this->getDoctrine()->getManager("default");
        $usuarios=$em2->getRepository('AppBundle:Usuario')->findAll();
        return $this->redirect($this->generateUrl('usuarios', array('usuarios'=>$usuarios)));
    }

}
