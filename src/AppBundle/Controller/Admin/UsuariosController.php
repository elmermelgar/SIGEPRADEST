<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UsuariosController extends Controller
{
    /**
     * @Route("/admin/empleados", name="empleados")
     */
    public function empleadosAction(){
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
            return $this->redirectToRoute("empleados");
        }
        return $this->render('AppBundle:Admin/Usuarios:nuevo_usuario.html.twig', array(
            'empleado' => $result,'ide' =>$ide));
    }

    /**
     * @Route("/admin/usuarios/", name="usuarios")
     */
    public function usuariosViewsAction(Request $request){
        $em2=$this->getDoctrine()->getManager("default");
        $usuarios=$em2->getRepository('AppBundle:Usuario')->findAll();
        return $this->render('AppBundle:Admin/Usuarios:usuarios_views.html.twig', array('usuarios'=>$usuarios));
    }

}
