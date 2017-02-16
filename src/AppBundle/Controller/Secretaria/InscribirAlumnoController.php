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

            $sql = "SELECT
 *
FROM
  alumno,
  usuario,
  solicitud estado_solicitud,
  curso

WHERE
  usuario.id_ui = alumno.id_ui AND
  usuario.id_ui = estado_solicitud.id_ui AND
  estado_solicitud.id_curso = curso.id_curso
  and estado_solicitud.estado = 'aprobada'
  and curso.id_curso = ".intval($id)."
GROUP BY
 usuario.nombre,
 usuario.id_ui,
  estado_solicitud.estado,
  curso.id_curso,
 alumno.id_alumno,
 estado_solicitud.id_solicitud";


//            $sql = "SELECT * FROM (SELECT a.id_alumno idalumno,s.id_solicitud,u.nombre,u.apellido,dp.dui_alumno,u.id_ui
//            FROM alumno a, solicitud s, usuario u, datos_personales dp
//            WHERE s.id_curso= :idcurso AND s.estado='inscrito' AND u.id_ui=s.id_ui AND dp.id_ui=u.id_ui AND a.id_ui=a.id_ui
//            ) al LEFT JOIN inscripcion_curso ic ON al.idalumno = ic.id_alumno AND ic.id_curso= :idcurso";
            $em=$this->getDoctrine()->getManager();
            $db = $em->getConnection();
            $stmt = $db->prepare($sql);
//            $stmt->bindValue('idcurso', $id);
            $stmt->execute();
            $alums = $stmt->fetchAll();
            $curso=$em->getRepository('AppBundle:Curso')->findOneBy(array('idCurso'=>$id));

//            var_dump($alums);

            return $this->render('AppBundle:Secretaria/IncribirAlumno:alumnos.html.twig', array('alum'=>$alums, 'curso' => $curso));

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
            $i = 0;

            for ($i; $i < count($array_alum); $i++) {
                $insc= new InscripcionCurso();

                $insc->setIdCurso($em->getRepository('AppBundle:Curso')->find($idcurso));

                $alum = $em->getRepository('AppBundle:Alumno')->find($array_alum[$i]);

                $insc->setIdAlumno($alum);

                $solicitud = $em->getRepository('AppBundle:Solicitud')->findBy(array("idUi" =>  $alum->getIdUi()->getIdUi(),
                   "idCurso"=> $idcurso));

                 $solicitud[0]->setEstado('inscrito');


                //Persistir
                $em->persist($insc);
                $em->persist( $solicitud[0]);

                //Guradar en la BD
                $em->flush();
            }
            if ($i > 0){
                $this->MensajeFlash('exito','Alumnos Inscritos Correctamente en el Curso!');
            }else{
                $this->MensajeFlash('error','No seleccionó alumnos para inscribir');
            }

            return $this->redirectToRoute("verCursoDisp");
        }
    }
}
