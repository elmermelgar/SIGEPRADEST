<?php

namespace AppBundle\Controller\Tutor;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\SecurityController;

class ModulosController extends SecurityController
{

    //Metodo para cambiar el password del tutor
    /**
     * @Route("/tutor/cambiarpass/{id}", name="cambiar_pass_tutor")
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
            return $this->redirect($this->generateUrl('tutor'));
        }
        return $this->render('AppBundle:Tutor/Modulos:cambiar_password_tutor.html.twig');
    }

    //Metodo para mostrar al tutor los cursos en los que ha sido asignado
    /**
     * @Route("/tutor/cursos/", name="cursos_asignados")
     */
    public function cursosAsignadosAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $datos=$this->getDoctrine()->getRepository('AppBundle:Doctores')->findOneBy(array('idUi'=>$this->getUser()));
        $idcurso=$datos->getIdCurso();
        $curso=$this->getDoctrine()->getRepository('AppBundle:Curso')->findAll();

        $db = $em->getConnection();
        $sql = "SELECT * FROM d1";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $d1 = $stmt->fetchAll();

        return $this->render('AppBundle:Tutor/Modulos:cusosAsignados.html.twig', array('doc'=>$datos,'d1'=>$d1,'cursos'=>$curso));
    }

    //Metodo para mostrar los modulos asignados
    /**
     * @Route("/tutor/modulos/{id}", name="modulos_curso")
     */
    public function modulosCursoAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $modulos=$this->getDoctrine()->getRepository('AppBundle:Modulos')->findBy(array('idCurso'=>$id));
        $curso=$this->getDoctrine()->getRepository('AppBundle:Curso')->find($id);
        $count=0;
        return $this->render('AppBundle:Tutor/Modulos:modulosCurso.html.twig', array('modulos'=>$modulos,'curso'=>$curso,'count'=>$count));
    }

    //Metodo para mostrar los alumnos inscritos en el curso
    /**
     * @Route("/tutor/alumnos/{id}/{id2}", name="alumnos_curso")
     */
    public function alumnosCursoAction($id, $id2, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $alumnos=$this->getDoctrine()->getRepository('AppBundle:InscripcionCurso')->findBy(array('idCurso'=>$id));
        $curso=$this->getDoctrine()->getRepository('AppBundle:Curso')->find($id);
        $modulo=$this->getDoctrine()->getRepository('AppBundle:Modulos')->findOneBy(array('idModulo'=>$id2));

        return $this->render('AppBundle:Tutor/Modulos:alumnos_views.html.twig', array('alumnos'=>$alumnos,'curso'=>$curso,'modulo'=>$modulo));
    }

    //Metodo para asignar notas a Estudiantes
    /**
     * @Route("/tutor/notas/{id1}/{id2}", name="notas_alumno")
     */
    public function notasAlumnoAction($id1,$id2, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $alumnos=$this->getDoctrine()->getRepository('AppBundle:InscripcionCurso')->findOneBy(array('idDc'=>$id2));
        $modulo=$this->getDoctrine()->getRepository('AppBundle:Modulos')->findOneBy(array('idModulo'=>$id1));
        $notas=$this->getDoctrine()->getRepository('AppBundle:Nota')->findBy(array('idDc'=>$id2,'idModulo'=>$id1));
        $por=0;
        $promedio=0;
        foreach($notas as $n){
            $por=$por+$n->getIdEvaluacion()->getPorcentaje();
        }
        foreach($notas as $n){
            $promedio=$promedio+($n->getNota()*($n->getIdEvaluacion()->getPorcentaje()));
        }
        return $this->render('AppBundle:Tutor/Modulos:notas_alumno.html.twig', array('alumnos'=>$alumnos,'modulo'=>$modulo,'notas'=>$notas,'por'=>$por,'promedio'=>$promedio));
    }

}
