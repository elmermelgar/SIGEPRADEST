<?php

namespace AppBundle\Controller\Director;

use AppBundle\Controller\DSIController;
use AppBundle\Entity\Solicitud;
use AppBundle\Tests\Controller\DetalleCursoControllerTest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

class CursosModulosController extends DSIController
{
    /**
     * @route("/director/historial",name="historial_director")
     */
    public function directorHistorialAction()
    {
        $em=$this->getDoctrine()->getManager("default");
        $cursos=$em->getRepository('AppBundle:Curso')->findAll();
        return $this->render('AppBundle:Director/Curso:historialcursosdirector.html.twig', array('cursos'=>$cursos));
    }
    /**
     * @Route("/director/curso_ver/{id}",name="detallesCursoDirector")
     */
    public function detallesCursoAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $doc = $em->getRepository("AppBundle:Doctores")->findBy(array(),array('nombreDoc'=>'ASC'));
        $tc=$em->getRepository("AppBundle:TipoCurso")->findAll();
        $datos=$em->getRepository('AppBundle:Curso')->find($id);
        $hc=$em->getRepository('AppBundle:HorarioCurso')->findOneBy(array('idCurso'=> $id));
        $id_hc=$hc->getIdHc();
        $hc=$em->getRepository('AppBundle:HorarioCurso')->find($id_hc);
        $d1=$this->mostrarD1s($id);
        $cuota=$em->getRepository('AppBundle:Cuotas')->findBy(array('idCurso'=> $id));

        return $this->render("AppBundle:Director/Curso:curso_ver.html.twig",array("tc"=>$tc,'datos'=>$datos,"doc"=>$doc,"hc"=>$hc,"d1"=>$d1, 'cuota'=>$cuota));
    }
    /**
     * @Route("/director/cursos",name="verCursoDirector")
     */
    public function verCursoDirectorAction()
    {
        if($this->getUser()){
            $em=$this->getDoctrine()->getManager("default");
            $cursos=$em->getRepository('AppBundle:Curso')->findAll();
            $hc=$em->createQuery('select curso from AppBundle:HorarioCurso curso ORDER BY curso.fechaInicio DESC ')->getResult();

            $fechaAhora=(new \DateTime('now',new \DateTimeZone('America/El_Salvador')))->format("Y-m-d");
            for($i=0;$i<count($hc);$i++){
                if($fechaAhora>($hc[$i]->getFechaFin()->format("Y-m-d"))){
                    $id=$em->getRepository('AppBundle:Curso')->find($hc[$i]->getIdCurso());
                    $id->setEstadoCurso("finanlizado");
                    //Guardar en la BD
                    $em->flush();
                }
            }
            return $this->render('AppBundle:Director/Curso:curso.html.twig', array('cursos'=>$cursos,'hc'=>$hc));
        }else{
            return $this->redirectToRoute('login');
        }

    }
}
