<?php

namespace AppBundle\Controller\Secretaria;

use AppBundle\Controller\DSIController;
use AppBundle\Entity\Curso;
use AppBundle\Entity\HorarioCurso;
use AppBundle\Entity\InscripcionCurso;
use AppBundle\Entity\Modulos;
use AppBundle\Entity\TipoCurso;
use AppBundle\Tests\Controller\DetalleCursoControllerTest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

class InscribirAlumnoController extends DSIController
{
    /**
     * @Route("/secretaria/cursos_disp",name="verCursoDisp")
     */
    public function verCursoDispAction()
    {
        if($this->getUser()){
            $em=$this->getDoctrine()->getManager("default");
            $cursos=$em->getRepository('AppBundle:Curso')->findBy(array('estadoCurso'=>'disponible'));
            $hc=$em->createQuery('select curso from AppBundle:HorarioCurso curso ORDER BY curso.fechaInicio DESC')->getResult();

            $doctores=$em->getRepository('AppBundle:Doctores')->findAll();
            $d1=$this->mostrarD1();

            return $this->render('AppBundle:Secretaria/IncribirAlumno:cursoDisp.html.twig', array('cursos'=>$cursos,'doctores'=>$doctores,'d1'=>$d1, 'hc'=>$hc));
        }else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/secretaria/alumno_ver/{id}",name="verAlumno")
     */
    public function verAlumnoAction($id)
    {
        if($this->getUser()){
            $em=$this->getDoctrine()->getManager("default");
            $alum=$em->getRepository('AppBundle:Alumno')->findBy(array('estadoAlumno'=>'activo'));
            $usu=$em->getRepository('AppBundle:Usuario')->findAll();
            $dp=$em->getRepository('AppBundle:DatosPersonales')->findAll();
            $cur=$em->getRepository('AppBundle:Curso')->find($id);
            $ins=$em->getRepository('AppBundle:InscripcionCurso')->findAll();

            return $this->render('AppBundle:Secretaria/IncribirAlumno:alumnos.html.twig', array('cur'=>$cur,'alum'=>$alum,'usu'=>$usu,'dp'=>$dp,'ins'=>$ins));
        }else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/secretaria/inscribir/{idcurso}/{idalumno}",name="inscribir")
     */
    public function inscAlumnoAction($idcurso,$idalumno)
    {
        $em=$this->getDoctrine()->getManager("default");
        $insc= new InscripcionCurso();
        $insc->setIdCurso($em->getRepository('AppBundle:Curso')->find($idcurso));
        $insc->setIdAlumno($em->getRepository('AppBundle:Alumno')->find($idalumno));

        //Persistir
        $em->persist($insc);

        //Guradar en la BD
        $em->flush();

        $alum=$em->getRepository('AppBundle:Alumno')->findBy(array('estadoAlumno'=>'activo'));
        $usu=$em->getRepository('AppBundle:Usuario')->findAll();
        $dp=$em->getRepository('AppBundle:DatosPersonales')->findAll();
        $cur=$em->getRepository('AppBundle:Curso')->find($idcurso);
        $ins=$em->getRepository('AppBundle:InscripcionCurso')->findAll();

        $this->MensajeFlash('exito','Alumno inscrito correctamente en el Curso!');

        return $this->render('AppBundle:Secretaria/IncribirAlumno:alumnos.html.twig', array('cur'=>$cur,'alum'=>$alum,'usu'=>$usu,'dp'=>$dp,'ins'=>$ins));
    }
}
