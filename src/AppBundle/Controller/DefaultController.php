<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Usuario;

class DefaultController extends Controller
{

    /**
     * @Route("/sql",name="sql")
     */
    public function sqlAction(){
        $em=$this->getDoctrine()->getEntityManager('default');
        $db = $em->getConnection();

        //$sql = "SELECT * FROM empleados";
        $sql = "SELECT * FROM usuario";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        //var_dump($result[0]["nomusuario"]);
        foreach($result as $r){
            echo $r["nomusuario"]."<br>";
        }
        die();
    }
    /**
     * @Route("/prueba", name="Prueba")
     */
    /*
    public function pruebaAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager("default");
        //Creando usuario
        $u = new Usuario();
        $u->setNomusuario("meom");
        $u->setIdtipousuario($em->getRepository('AppBundle:Tipousuario')->find(1));
        //Cifra la contrase?a
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($u);
        $password = $encoder->encodePassword("12345", $u->getSalt());
        $u->setPassword($password);
        $u->setIsactive(1);
        //Persistencia
        $em->persist($u);
        $em->flush();
        //redireccionamiento
        //return new Response("Insertado");
        echo 'Insertado';
        die();
    }*/
    /**
     * @Route("/index", name="control_redirect")
     */
    public function controlRedirectAction(){
            //return $this->render('::base.html.twig');*/
        $rol=$this->getUser()->getIdtipousuario()->getIdtipousuario();
        if($rol==1)
            return $this->redirectToRoute('admin');
        if($rol==2)
            return $this->redirectToRoute('doctor');
        if($rol==3)
            return $this->redirectToRoute('alumno');
        if($rol==4)
            return $this->redirectToRoute('interesado');
        //return $this->redirectToRoute('interesado');
    }
    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction(){
        return $this->render(':default:funcion.html.twig');
    }
    /**
     * @Route("/admin/funcion", name="funcion")
     */
    public function funcionAction(){
        return $this->render(':default:funcion.html.twig');
    }
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

        return $this->render(':login:login.html.twig',
            array(
                'last_username' => $lastUsername,
                'error' => $error));

        //Preguntar como redirigir de el formulario del login a otra pag.

    }
    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
    }
    /**
     * @Route("/interesado", name="interesado")
     */
    public function interesadoAction()
    {
        echo 'Zona de Interesado';
        die();
    }
    /**
     * @Route("/doctor", name="doctor")
     */
    public function doctorAction()
    {
        echo 'Zona de Doctor';
        die();
    }
    /**
     * @Route("/alumno", name="alumno")
     */
    public function alumnoAction()
    {
        echo 'Zona de Alumno';
        die();
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
    }




}
