<?php

namespace AppBundle\Controller\Director;

use AppBundle\Controller\DSIController;
use AppBundle\Entity\Solicitud;
use AppBundle\Entity\Cita;
use AppBundle\Entity\HorarioEntrevista;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\DatosPersonales;
use AppBundle\Entity\Curso;

use AppBundle\Tests\Controller\DetalleCursoControllerTest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

class SolicitudDiController extends DSIController
{
    /**
     * @route("/director/sol",name="verSol(dir)")
     */
    public function verSolDirAction()
    {
        if($this->getUser()){
            $em=$this->getDoctrine()->getManager("default");
            $sql = $em->createQuery("SELECT ct FROM AppBundle\Entity\Cita ct, AppBundle\Entity\Curso cu, AppBundle\Entity\Solicitud so
            WHERE ct.idSolicitud=so.idSolicitud AND so.idCurso=cu.idCurso 
            AND cu.estadoCurso='disponible' AND so.estado='evaluacion'");

            $citas = $sql->getResult();
            $insc=$em->getRepository('AppBundle:InscripcionCurso')->findAll();

            return $this->render('AppBundle:Director/Solicitud(eva):Sol.html.twig', array('citas'=>$citas, 'insc'=>$insc));
        }else{
            return $this->redirectToRoute('login');
        }
    }
    /**
     * @route("/director/sol_aprobar/{id}",name="aprobarSol")
     */
    public function aprobarSolAtion($id)
    {
        $em=$this->getDoctrine()->getManager("default");
        $sol=$em->getRepository('AppBundle:Solicitud')->find($id);
        $cur=$em->getRepository('AppBundle:Curso')->find($sol->getIdCurso());
        $inscritos=$em->getRepository("AppBundle:InscripcionCurso")->findBy(array('idCurso'=>$cur->getIdCurso()));
        if($cur->getCantAlumnosLimit()<>count($inscritos)){
            $sol->setEstado('aprobada');
            //Guardar en la BD
            $em->flush();

            return $this->redirectToRoute('verSol(dir)');
        }else{
            $this->MensajeFlash('error','El curso ya no tiene cupos disponibles');
            return $this->redirectToRoute('verSol(dir)');
        }

    }

    /**
     * @route("/director/sol_denegar/{id}",name="denagarSol")
     */
    public function denegarSolAtion($id)
    {
        $em=$this->getDoctrine()->getManager("default");
        $sol=$em->getRepository('AppBundle:Solicitud')->find($id);
        $sol->setEstado('denegada');
        //Guardar en la BD
        $em->flush();

        return $this->redirectToRoute('verSol(dir)');
    }

    /**
     * @route("/director/detalle/sol/{ids}",name="verDetalleSol")
     */
    public function verDetalleSolAction($ids)
    {
        if($this->getUser()){
            $em=$this->getDoctrine()->getManager("default");
            //solicitud de ingreso
            $repoSol = $em->getRepository('AppBundle:Solicitud');
            $sol = $repoSol->findOneBy(array(
                'idSolicitud' => $ids
            ));
            //Informacion academica
            $repoia = $this->getDoctrine()->getRepository('AppBundle:InformacionAcademica');
            $infoacademica = $repoia->findBy(
                array('idSolicitud' => $ids)
            );
            return $this->render('AppBundle:Director/Solicitud(eva):detalleSol.html.twig', array(
                'perfil' => $sol->getIdDp(),
                'solicitud' => $sol,
                'estudios' => $infoacademica,
                'curso' => $sol->getIdCurso()
            ));
        }else{
            return $this->redirectToRoute('login');
        }
    }

}
