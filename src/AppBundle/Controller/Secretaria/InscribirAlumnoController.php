<?php

namespace AppBundle\Controller\Secretaria;

use AppBundle\Controller\DSIController;
use AppBundle\Entity\Curso;
use AppBundle\Entity\HorarioCurso;
use AppBundle\Entity\InscripcionCurso;
use AppBundle\Entity\Modulos;
use AppBundle\Entity\TipoCurso;
use AppBundle\Tests\Controller\DetalleCursoControllerTest;
use AppBundle\Entity\Alumno;
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
            $usu=$em->getRepository('AppBundle:Usuario')->findAll();
            $dp=$em->getRepository('AppBundle:DatosPersonales')->findAll();
            $cur=$em->getRepository('AppBundle:Curso')->find($id);
            $alum=$em->getRepository('AppBundle:Alumno')->findAll();
            $ins=$em->getRepository('AppBundle:InscripcionCurso')->findAll();

            for($i=0; $i<count($alum); $i++){
                $contador=0;
                if($ins){
                    for($j=0; $j<count($ins); $j++){
                        if($alum[$i]->getIdAlumno()==$ins[$j]->getIdAlumno()->getIdAlumno()){
                            $contador=$contador+1;
                        }
                    }
                    if($contador==0){
                        $aluminsc[]=$alum[$i];
                    }
                }else{
                    $aluminsc[]=$alum[$i];
                }

            }

//            $alum=$em->createQuery("Select alum from AppBundle:Alumno as alum , AppBundle:InscripcionCurso as inscri WHERE alum.estadoAlumno = 'activo' AND alum.idAlumno != inscri.idAlumno")->getResult();

            return $this->render('AppBundle:Secretaria/IncribirAlumno:alumnos.html.twig', array('alum'=>$aluminsc,'cur'=>$cur,'usu'=>$usu,'dp'=>$dp));
        }else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/secretaria/inscribir/{idcurso}",name="inscribir")
     */
    public function inscAlumnoAction($idcurso, Request $request)
    {
        $em=$this->getDoctrine()->getManager("default");
        //Verificando que hay una peticion POST
        if($request->isMethod("POST")) {
            //Recuperar y seteando valores enviados
            $array_alum = $request->get("alum");
            for ($i = 0; $i < count($array_alum); $i++) {
                $insc= new InscripcionCurso();
                $insc->setIdCurso($em->getRepository('AppBundle:Curso')->find($idcurso));
                $insc->setIdAlumno($em->getRepository('AppBundle:Alumno')->find($array_alum[$i]));

                //Persistir
                $em->persist($insc);

                //Guradar en la BD
                $em->flush();
            }

            $this->MensajeFlash('exito','Alumnos Inscritos Correctamente en el Curso!');
            return $this->redirectToRoute("verCursoDisp");
        }
    }
}
