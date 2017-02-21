<?php

namespace AppBundle\Controller\Director;

use AppBundle\Controller\DSIController;
use AppBundle\Entity\Doctores;
use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\SecurityController;

class Usuarios2Controller extends DSIController
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
                if ($_FILES["foto"]["error"] > 0) {
                    return new Response('Error en la subida de la Fotografía');
                } else {
                    if ($this->infoTipoImagen('foto')[0] == 'image') {

                        $existe = $em2->getRepository('AppBundle:Usuario')->findOneBy(array('nomusuario' => $request->get("username")));
                        $email = $em2->getRepository('AppBundle:Usuario')->findOneBy(array('correo' => $request->get("email")));
                        if ($existe or $email) {
                            $this->MensajeFlash('error', 'El nombre de usuario o correo ya existe!');
                            $em2 = $this->getDoctrine()->getManager("default");
                            $usuarios = $em2->getRepository('AppBundle:Usuario')->findAll();
                            return $this->redirect($this->generateUrl('usuarios2', array('usuarios' => $usuarios)));
                        } else {
                            $nombrefoto=$request->get('username').$this->infoTipoImagen('foto')[1];
                            //Creando usuario
                            $u = new Usuario();
                            $u->setFoto("img/tutor/".$nombrefoto);
                            $u->setFechaNacimientoUi(\DateTime::createFromFormat('d/m/Y',$request->get("fechaNac")));
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

                            //Subiendo la Imagen
                            $this->subirFotografia('foto',$nombrefoto);

                            //redireccionamiento
                            $this->MensajeFlash('exito', 'Usuario creado correctamente!');

                            $em2 = $this->getDoctrine()->getManager("default");
                            $usuarios = $em2->getRepository('AppBundle:Usuario')->findAll();
                            return $this->redirect($this->generateUrl('usuarios2', array('usuarios' => $usuarios)));
                        }
                    } else {
                        $this->MensajeFlash('error', 'El archivo no es una imagen!');
                        return $this->render("AppBundle:Director/Usuarios2:nuevo_usuario.html.twig");
                    }
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
        $tutor=$this->getDoctrine()->getRepository('AppBundle:Doctores')->findOneBy(array("idUi"=>$id));
        if ($request->isMethod("POST")) {
            $usu = $em2->getRepository('AppBundle:Usuario')->find($id);
            $correo = $usu->getCorreo();
            if($correo==$request->get('email')){
                $datos->setFechaNacimientoUi(\DateTime::createFromFormat('d/m/Y',$request->get("fechaNac")));
                $datos->setNombre($request->get("nombre"));
                $datos->setCorreo($request->get("email"));
                $datos->setApellido($request->get("apellido"));
                $datos->setTelefono($request->get("tel"));
                $datos->setIdEmpleado($request->get("id_emp"));

                $tutor->setNombreDoc($request->get("nombre"));
                $tutor->setApellidoDoc($request->get("apellido"));
                $tutor->setDuiDoc($request->get("id_emp"));
                $tutor->setEspecialidad($request->get("especialidad"));
                $tutor->setTurno($request->get("turno"));

                $em2->flush();

                //redireccionamiento
                $this->MensajeFlash('exito', 'Tutor actualizado correctamente!');

                $em2 = $this->getDoctrine()->getManager("default");
                $usuarios = $em2->getRepository('AppBundle:Usuario')->findAll();
                return $this->redirect($this->generateUrl('usuarios2', array('usuarios' => $usuarios)));

            }else{
                $email = $em2->getRepository('AppBundle:Usuario')->findOneBy(array('correo' => $request->get("email")));
                if ($email) {
                    $this->MensajeFlash('error', 'El correo ya existe!');
                    $em2 = $this->getDoctrine()->getManager("default");
                    $usuarios = $em2->getRepository('AppBundle:Usuario')->findAll();
                    return $this->redirect($this->generateUrl('usuarios2', array('usuarios' => $usuarios)));
                }
                else{
                    $datos->setFechaNacimientoUi(new \DateTime($request->get("fechaNac")));
                    $datos->setNombre($request->get("nombre"));
                    $datos->setCorreo($request->get("email"));
                    $datos->setApellido($request->get("apellido"));
                    $datos->setTelefono($request->get("tel"));
                    $datos->setIdEmpleado($request->get("id_emp"));

                    $tutor->setNombreDoc($request->get("nombre"));
                    $tutor->setApellidoDoc($request->get("apellido"));
                    $tutor->setDuiDoc($request->get("id_emp"));
                    $tutor->setEspecialidad($request->get("especialidad"));
                    $tutor->setTurno($request->get("turno"));

                    $em2->flush();

                    //redireccionamiento
                    $this->MensajeFlash('exito', 'Tutor actualizado correctamente!');

                    $em2 = $this->getDoctrine()->getManager("default");
                    $usuarios = $em2->getRepository('AppBundle:Usuario')->findAll();
                    return $this->redirect($this->generateUrl('usuarios2', array('usuarios' => $usuarios)));
                }
            }
        }
        return $this->render('AppBundle:Director/Usuarios2:editar_usuario.html.twig', array('usuario' => $datos, 'doc' => $tutor));
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

    /**
     * @Route("/director/DetalleTutor/{id}", name="verTutor")
     */
    public function verTutorAction($id){
        if($this->getUser()){
            $em=$this->getDoctrine()->getManager();
            $tutores=$em->getRepository('AppBundle:Usuario')->find($id);
            $doctores=$em->getRepository('AppBundle:Doctores')->findOneBy(array("idUi"=>$id));
            if($doctores != NULL){
                $curd1=$this->cur($doctores->getIdDoctores());
            }else{
                $curd1=NULL;
            }
            $curso=$em->getRepository('AppBundle:Curso')->findAll();

            return $this->render('AppBundle:Director/Usuarios2:ver_tutor.html.twig', array('tuto'=>$tutores, 'doc'=>$doctores, 'cur'=>$curd1, 'curso'=>$curso));
        }
        else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/director/tutor_cambiarImg/{id}",name="camImgTu")
     */
    public function cambiarImgAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $t = $em->getRepository('AppBundle:Usuario')->find($id);

        //Verificando que hay una peticion POST
        if($request->isMethod("POST")) {
            if ($_FILES["imagen"]["error"] > 0) {
                return new Response('Error en la subida de la imagen');
            } else {
                if ($this->infoTipoImagen('imagen')[0] == 'image') {
                    $nomUser = $t->getUsername();
                    $nombreImagen = $nomUser . $this->infoTipoImagen('imagen')[1];
                    //Subiendo la Imagen
                    $this->subirFotografia('imagen', $nombreImagen);
                    $this->MensajeFlash('exito', 'Imagen del curso editada correctamente!');
                    return $this->redirectToRoute("verTutor", array('id' => $id));
                } else {
                    $this->MensajeFlash('error', 'El archivo no es una imagen!');
                    return $this->redirectToRoute("verTutor", array('id' => $id));
                }
            }
        }

    }

}
