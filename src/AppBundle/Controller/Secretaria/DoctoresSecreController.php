<?php

namespace AppBundle\Controller\Secretaria;

use AppBundle\Entity\Doctores;
use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\SecurityController;

class DoctoresSecreController extends SecurityController
{

    /**
     * @Route("/secretaria/empleados_sec", name="empleados_doc")
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

            return $this->render('AppBundle:Secretaria/Doctores:empleados.html.twig', array(
                'empleados' => $result));
        }
        else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/secretaria/doctor/create/{id}", name="new_doctor")
     */
    public function nuevoDoctorAction($id, Request $request){
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
            //Creando un doctor
            $doc = new Doctores();
            $doc->setNombreDoc($request->get("nombre_doc"));
            $doc->setEspecialidad($request->get("especialidad"));
            $doc->setApellidoDoc($request->get("apellido_doc"));
            $doc->setTurno($request->get("turno"));
            $doc->setDuiDoc($request->get("dui"));

            //Persistencia
            $em2->persist($doc);
            $em2->flush();
            //mensaje de exito
            $this->MensajeFlash('exito','Doctor creado correctamente!');
            //redireccionamiento
            $em2=$this->getDoctrine()->getManager("default");
            $doctores=$em2->getRepository('AppBundle:Doctores')->findAll();
            return $this->redirect($this->generateUrl('doctores_secre', array('doctores'=>$doctores)));
        }
        return $this->render('AppBundle:Secretaria/Doctores:nuevo_doctor.html.twig', array(
            'empleado' => $result,'ide' =>$ide));
    }

    /**
     * @Route("/secretaria/doctor_ext/create", name="new_doctor_ext")
     */
    public function nuevoDoctorExtAction(Request $request){
        $em2=$this->getDoctrine()->getManager("default");
        if($request->isMethod("POST"))
        {
            //Creando un doctor
            $doc = new Doctores();
            $doc->setNombreDoc($request->get("nombre_doc"));
            $doc->setEspecialidad($request->get("especialidad"));
            $doc->setApellidoDoc($request->get("apellido_doc"));
            $doc->setTurno($request->get("turno"));
            $doc->setDuiDoc($request->get("dui"));

            //Persistencia
            $em2->persist($doc);
            $em2->flush();
            //mensaje de exito
            $this->MensajeFlash('exito','Doctor creado correctamente!');
            //redireccionamiento
            $em2=$this->getDoctrine()->getManager("default");
            $doctores=$em2->getRepository('AppBundle:Doctores')->findAll();
            return $this->redirect($this->generateUrl('doctores_secre', array('doctores'=>$doctores)));
        }
        return $this->render('AppBundle:Secretaria/Doctores:nuevo_doctor_ext.html.twig');
    }

    /**
     * @Route("/secretaria/doctor/{id}/edit", name="edit_doctor")
     */
    public function editarDoctorAction($id, Request $request){
        $em2=$this->getDoctrine()->getManager("default");
        //Seleccionando un solo doctor";
        $doc=$this->getDoctrine()->getRepository('AppBundle:Doctores')->find($id);
        if($request->isMethod("POST"))
        {

            $doc->setEspecialidad($request->get("especialidad"));
            $doc->setNombreDoc($request->get("nombre_doc"));
            $doc->setApellidoDoc($request->get("apellido_doc"));
            $doc->setDuiDoc($request->get("dui"));
            $doc->setTurno($request->get("turno"));
            //Actualizando valores
            $em2->flush();
            //mensaje de confirmacion
            $this->MensajeFlash('exito','Doctor actualizado correctamente!');
            //redireccionamiento
            $em2=$this->getDoctrine()->getManager("default");
            $doctores=$em2->getRepository('AppBundle:Doctores')->findAll();
            return $this->redirect($this->generateUrl('doctores_secre', array('doctores'=>$doctores)));
        }
        return $this->render('AppBundle:Secretaria/Doctores:editar_doctor.html.twig', array(
            'doctor' => $doc));
    }

    /**
     * @Route("/secretaria/doctores/", name="doctores_secre")
     */
    public function doctoresViewsAction(Request $request){
        if($this->getUser()){
            $em2=$this->getDoctrine()->getManager("default");
            $doctores=$em2->getRepository('AppBundle:Doctores')->findAll();
            return $this->render('AppBundle:Secretaria/Doctores:doctores_views.html.twig', array('doctores'=>$doctores));
        }
        else{
            return $this->redirectToRoute('login');
        }
    }
    /**
     * @Route("/secretaria/doctor/delete/{id}", name="delete_doctor")
     */
    public function deleteDoctorAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $doctor=$em->getRepository('AppBundle:Doctores')->find($id);
        if(!$doctor){
            throw $this->createNotFoundException('No existe el usuario con el ID'.$id);
        }
        $em->remove($doctor);
        $em->flush();
        $this->MensajeFlash('exito','Doctor eliminado correctamente!');

        $em2=$this->getDoctrine()->getManager("default");
        $doctor=$em2->getRepository('AppBundle:Doctores')->findAll();
        return $this->redirect($this->generateUrl('doctores_secre', array('doctores'=>$doctor)));
    }

}
