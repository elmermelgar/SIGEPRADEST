<?php

namespace AppBundle\Controller\Tutor;

use AppBundle\Entity\Evaluacion;
use AppBundle\Entity\Nota;
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
        $eva=$this->getDoctrine()->getRepository('AppBundle:Evaluacion')->findBy(array('idModulo'=>$id1));
        $por=0;
        $promedio=0;
        $db = $em->getConnection();
        $sql = "select e.* from evaluacion as e left join nota as n on e.id_evaluacion=n.id_evaluacion where n.id_evaluacion not in (select n.id_evaluacion from evaluacion as e,nota as n where e.id_evaluacion=n.id_evaluacion and n.id_dc=$id2) and e.id_modulo=$id1";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $disp = $stmt->fetchAll();
        foreach($notas as $n){
            $por=$por+$n->getIdEvaluacion()->getPorcentaje();
        }
        foreach($notas as $n){
            $promedio=$promedio+($n->getNota()*($n->getIdEvaluacion()->getPorcentaje()));
        }
        if($request->isMethod("POST")) {
            $nota=$this->getDoctrine()->getRepository('AppBundle:Nota')->findOneBy(array('idEvaluacion'=>$request->get("evaluacion"), 'idDc'=>$id2, 'idModulo'=>$id1));

            if($nota){
                $this->MensajeFlash('error','Ya ha sido asignada una nota para esta evaluacion');
                return $this->redirectToRoute('notas_alumno', array('id1'=>$id1,'id2'=>$id2));
            }
            else{
                $not=new Nota();
                $not->setNota($request->get('nota'));
                $not->setIdEvaluacion($this->getDoctrine()->getRepository('AppBundle:Evaluacion')->find($request->get("evaluacion")));
                $not->setIdModulo($modulo);
                $not->setIdDc($alumnos);
                $em->persist($not);
                $em->flush();

                $this->MensajeFlash('exito','Nota registrada con exito');
                return $this->redirectToRoute('notas_alumno', array('id1'=>$id1,'id2'=>$id2));
            }
        }
        return $this->render('AppBundle:Tutor/Modulos:notas_alumno.html.twig', array('alumnos'=>$alumnos,'modulo'=>$modulo,'notas'=>$notas,'por'=>$por,'promedio'=>$promedio,'eva'=>$eva));
    }

    //Metodo para ver y agregar evaluaciones
    /**
     * @Route("/tutor/evaluaciones/{id}", name="evaluaciones")
     */
    public function evaluacionesAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $modulo=$this->getDoctrine()->getRepository('AppBundle:Modulos')->findOneBy(array('idModulo'=>$id));
        $modu=$this->getDoctrine()->getRepository('AppBundle:Modulos')->find($id);
        $mod=$modulo->getNombreModulo();
        $idmod=$modulo->getIdModulo();
        $curso=$this->getDoctrine()->getRepository('AppBundle:Curso')->find($modulo->getIdCurso());
        $eva=$modulo=$this->getDoctrine()->getRepository('AppBundle:Evaluacion')->findBy(array('idModulo'=>$id));
        $por=0;
        foreach($eva as $ev){
            $por=$por+$ev->getPorcentaje();
        }
        if($request->isMethod("POST")) {
            $actual=$por+$request->get("por");
            if($actual<=100){
            $evaluacion=new Evaluacion();
            $evaluacion->setNombreEvaluacion($request->get("eva"));
            $evaluacion->setPorcentaje($request->get("por"));
            $evaluacion->setIdModulo($modu);
            $em->persist($evaluacion);
            $em->flush();
                $this->MensajeFlash('exito','Evaluacion creada correctamente');
            return $this->redirectToRoute('evaluaciones', array('id'=>$idmod));
            }
            else{
                $this->MensajeFlash('error','No puede exceder el limite de 100% en la suma de los porcentajes de las evaluaciones');
                return $this->redirectToRoute('evaluaciones', array('id'=>$idmod));
            }
        }
        return $this->render('AppBundle:Tutor/Modulos:evaluaciones.html.twig', array('curso'=>$curso,'modulo'=>$mod,'evaluacion'=>$eva,'por'=>$por,'idmod'=>$idmod));
    }

    //Metodo para editar evaluaciones
    /**
     * @Route("/tutor/evaluaciones/{id}/edit/{id2}", name="evaluacion_edit")
     */
    public function evaluacionesEditAction($id,$id2, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $modulo=$this->getDoctrine()->getRepository('AppBundle:Modulos')->findOneBy(array('idModulo'=>$id));
        $modu=$this->getDoctrine()->getRepository('AppBundle:Modulos')->find($id);
        $mod=$modulo->getNombreModulo();
        $idmod=$modulo->getIdModulo();
        $curso=$this->getDoctrine()->getRepository('AppBundle:Curso')->find($modulo->getIdCurso());
        $evaluacion=$modulo=$this->getDoctrine()->getRepository('AppBundle:Evaluacion')->find($id2);
        $eva=$modulo=$this->getDoctrine()->getRepository('AppBundle:Evaluacion')->findBy(array('idModulo'=>$id));
        $por=0;
        foreach($eva as $ev){
            $por=$por+$ev->getPorcentaje();
        }
        if($request->isMethod("POST")) {
            $actual=$por-$evaluacion->getPorcentaje()+$request->get("por");
            if($actual<=100){
                $evaluacion->setNombreEvaluacion($request->get("eva"));
                $evaluacion->setPorcentaje($request->get("por"));
                $evaluacion->setIdModulo($modu);
                $em->persist($evaluacion);
                $em->flush();
                $this->MensajeFlash('exito','Actualizado correctamente');
                return $this->redirectToRoute('evaluaciones', array('id'=>$idmod));
            }
            else{
                $this->MensajeFlash('error','No puede exceder el limite de 100% en la suma de los porcentajes de las evaluaciones !');
                return $this->redirectToRoute('evaluaciones', array('id'=>$idmod));
            }
        }
        return $this->render('AppBundle:Tutor/Modulos:evaluacion_edit.html.twig', array('curso'=>$curso,'modulo'=>$mod,'evaluacion'=>$evaluacion,'idmod'=>$idmod));
    }
    //Metodo para eliminar evaluaciones
    /**
     * @Route("/tutor/evaluaciones/{id}/delete{id2}", name="evaluacion_delete")
     */
    public function deleteUsuarioAction($id,$id2, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $evaluacion=$modulo=$this->getDoctrine()->getRepository('AppBundle:Evaluacion')->find($id2);
        $nota=$modulo=$this->getDoctrine()->getRepository('AppBundle:Nota')->findBy(array('idEvaluacion'=>$id2));
        $modu=$this->getDoctrine()->getRepository('AppBundle:Modulos')->find($id);
        $idmod=$modu->getIdModulo();
        if(!$evaluacion){
            throw $this->createNotFoundException('No existe el usuario con el ID'.$id2);
        }
        if($nota){
            $this->MensajeFlash('error','No tiene permiso de eliminar el registro porque existe una Nota asociada');
            return $this->redirectToRoute('evaluaciones', array('id'=>$idmod));
        }
        else{
            $em->remove($evaluacion);
            $em->flush();
            $this->MensajeFlash('exito','Evaluacion eliminada correctamente!');
            return $this->redirectToRoute('evaluaciones', array('id'=>$idmod));
        }

    }

}
