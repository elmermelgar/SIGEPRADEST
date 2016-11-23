<?php

namespace AppBundle\Controller\Secretaria;

use AppBundle\Controller\DSIController;
use AppBundle\Entity\Cita;
use AppBundle\Entity\EvaluacionPrevia;
use AppBundle\Tests\Controller\DetalleCursoControllerTest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

class CitaController extends DSIController
{
    /**
     * @Route("/secretaria/cita_create/{id}",name="createCita")
     */
    public function createCitaAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager("default");
        $sol=$em->getRepository('AppBundle:Solicitud')->find($id);
        $he=$em->getRepository('AppBundle:HorarioEntrevista')->findBy(array('ocupado'=>'false', 'idCurso'=>$sol->getIdCurso()->getIdCurso()));
        if($he){
            //Verificando que hay una peticion POST
            if($request->isMethod("POST")) {
                //Recuperar y seteando valores enviados
                $cita = new Cita();
                $cita->setIdHe($em->getRepository("AppBundle:HorarioEntrevista")->find($request->get("he")));
                $cita->setIdSolicitud($em->getRepository("AppBundle:Solicitud")->find($id));
                $cita->setComentarioCita($request->get('comen'));

                $eva = new EvaluacionPrevia();
                $eva->setIdHe($em->getRepository("AppBundle:HorarioEntrevista")->find($request->get("he")));
                $eva->setIdSolicitud($em->getRepository("AppBundle:Solicitud")->find($id));
                $eva->setComentarioEvaluacion($request->get('comen'));

                //Persistir
                $em->persist($cita);
                $em->persist($eva);

                $he2=$em->getRepository('AppBundle:HorarioEntrevista')->find($request->get('he'));
                $he2->setOcupado(true);
                $sol->setEstado('evaluacion');

                //Guradar en la BD
                $em->flush();

                $this->MensajeFlash('exito','Cita creada correctamente!');
                return $this->redirectToRoute("verSol(sec)");
            }
            return $this->render("AppBundle:Secretaria/Cita:cita_create.html.twig", array("sol"=>$sol,'he'=>$he, 'idsol'=>$id));
        }else{
            $this->MensajeFlash('error','Debe crear primero Horarios de Entrevista para este Curso');
            return $this->redirectToRoute("verEntrevista");
        }



    }
}
