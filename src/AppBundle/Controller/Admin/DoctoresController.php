<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Doctores;
use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\SecurityController;

class DoctoresController extends SecurityController
{

    /**
     * @Route("/admin/empleados_", name="empleados_")
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

            return $this->render('AppBundle:Admin/Doctores:empleados.html.twig', array(
                'empleados' => $result));
        }
        else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/admin/doctor/create/{id}", name="nuevo_doctor")
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
            $doc->setEspecialidad($request->get("especialidad"));
            $doc->setNombreDoc($request->get("nombre_doc"));
            $doc->setTurno($request->get("turno"));

            //Persistencia
            $em2->persist($doc);
            $em2->flush();
            //mensaje de exito
            $this->MensajeFlash('exito','Doctor creado correctamente!');
            //redireccionamiento
            $em2=$this->getDoctrine()->getManager("default");
            $doctores=$em2->getRepository('AppBundle:Doctores')->findAll();
            return $this->redirect($this->generateUrl('doctores', array('doctores'=>$doctores)));
        }
        return $this->render('AppBundle:Admin/Doctores:nuevo_doctor.html.twig', array(
            'empleado' => $result,'ide' =>$ide));
    }

    /**
     * @Route("/admin/doctor/{id}/edit", name="editar_doctor")
     */
    public function editarDoctorAction($id, Request $request){
        $em2=$this->getDoctrine()->getManager("default");
        //Seleccionando un solo doctor";
        $doc=$this->getDoctrine()->getRepository('AppBundle:Doctores')->find($id);
        if($request->isMethod("POST"))
        {

            $doc->setEspecialidad($request->get("especialidad"));
            $doc->setNombreDoc($request->get("nombre_doc"));
            $doc->setTurno($request->get("turno"));
            //Actualizando valores
            $em2->flush();
            //mensaje de confirmacion
            $this->MensajeFlash('exito','Doctor actualizado correctamente!');
            //redireccionamiento
            $em2=$this->getDoctrine()->getManager("default");
            $doctores=$em2->getRepository('AppBundle:Doctores')->findAll();
            return $this->redirect($this->generateUrl('doctores', array('doctores'=>$doctores)));
        }
        return $this->render('AppBundle:Admin/Doctores:editar_doctor.html.twig', array(
            'doctor' => $doc));
    }

    /**
     * @Route("/admin/doctores/", name="doctores")
     */
    public function doctoresViewsAction(Request $request){
        if($this->getUser()){
            $em2=$this->getDoctrine()->getManager("default");
            $doctores=$em2->getRepository('AppBundle:Doctores')->findAll();
            return $this->render('AppBundle:Admin/Doctores:doctores_views.html.twig', array('doctores'=>$doctores));
        }
        else{
            return $this->redirectToRoute('login');
        }
    }
    /**
     * @Route("/admin/doctor/delete/{id}", name="eliminar_doctor")
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
        return $this->redirect($this->generateUrl('doctores', array('doctores'=>$doctor)));
    }

}
