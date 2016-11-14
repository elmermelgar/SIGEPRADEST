<?php

namespace AppBundle\Controller\Alumno;

use AppBundle\Entity\Evaluacion;
use AppBundle\Entity\Nota;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\SecurityController;

class ModulosAlumnoController extends SecurityController
{

    //Metodo para mostrar al Alumno los cursos en los que ha sido asignado
    /**
     * @Route("/alumno/cursos/", name="cursos_alumno")
     */
    public function cursosAsignadosAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $datos=$this->getDoctrine()->getRepository('AppBundle:Alumno')->findOneBy(array('idUi'=>$this->getUser()->getIdUi()));
        $inscrip=$this->getDoctrine()->getRepository('AppBundle:InscripcionCurso')->findBy(array('idAlumno'=>$datos->getIdAlumno()));
        $curso=$this->getDoctrine()->getRepository('AppBundle:Curso')->findAll();

        return $this->render('AppBundle:Alumno/Cursos:cusosInscritos.html.twig', array('alumno'=>$datos,'inscrip'=>$inscrip,'cursos'=>$curso));
    }

    //Metodo para mostrar los modulos al alumno
    /**
     * @Route("/alumno/modulos/{id}/{id2}", name="modulos_curso_alumno")
     */
    public function modulosCursoAction($id,$id2, Request $request)
    {
        $modulos=$this->getDoctrine()->getRepository('AppBundle:Modulos')->findBy(array('idCurso'=>$id));
        $inscrip=$this->getDoctrine()->getRepository('AppBundle:InscripcionCurso')->find($id2);
        $curso=$this->getDoctrine()->getRepository('AppBundle:Curso')->find($id);
        $count=0;
        return $this->render('AppBundle:Alumno/Cursos:modulosCurso.html.twig', array('modulos'=>$modulos,'curso'=>$curso,'inscrip'=>$inscrip));
    }

    //Metodo para mostrar notas a Estudiantes
    /**
     * @Route("/alumno/notas/{id1}/{id2}", name="mis_notas")
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
        return $this->render('AppBundle:Alumno/Cursos:mis_notas.html.twig', array('alumnos'=>$alumnos,'modulo'=>$modulo,'curso'=>$alumnos->getIdCurso()->getIdCurso(),'notas'=>$notas,'por'=>$por,'promedio'=>$promedio));
    }

    

}
