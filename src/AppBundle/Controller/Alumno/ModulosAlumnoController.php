<?php

namespace AppBundle\Controller\Alumno;

use AppBundle\Controller\DSIController;
use AppBundle\Entity\Evaluacion;
use AppBundle\Entity\Nota;
use AppBundle\Entity\PagoCuota;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\SecurityController;

class ModulosAlumnoController extends DSIController
{
    //Metodo para mostrar al Alumno los detalles de los cursos disponibles
    /**
     * @Route("/alumno/curso_ver/{id}",name="detallesCursoAlum")
     */
    public function detallesAction($id)
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

        return $this->render("AppBundle:Alumno:curso_ver.html.twig",array("tc"=>$tc,'datos'=>$datos,"doc"=>$doc,"hc"=>$hc,"d1"=>$d1, 'cuota'=>$cuota));
    }

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

    //Metodo para mostrar las cuotas y los pagos
    /**
     * @Route("/alumno/cuotas/{id}/{id2}", name="cuotas_curso_alumno")
     */
    public function cuotasCursoAction($id,$id2, Request $request)
    {
        $em=$this->getDoctrine()->getManager("default");
        $cuotas=$this->getDoctrine()->getRepository('AppBundle:Cuotas')->findBy(array('idCurso'=>$id));
        $db = $em->getConnection();
        $sql = "select c.* from cuotas c where c.id_curso=$id and c.id_cuota not in (select id_cuota from pago_cuota where id_dc=$id2) ORDER BY cuota ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $cuotasp = $stmt->fetchAll();

        $alumno=$this->getDoctrine()->getRepository('AppBundle:Alumno')->findOneBy(array('idUi'=>$this->getUser()));
        $inscrip=$this->getDoctrine()->getRepository('AppBundle:InscripcionCurso')->findOneBy(array('idCurso'=>$id,'idAlumno'=>$alumno->getIdAlumno()));
        $pago=$this->getDoctrine()->getRepository('AppBundle:PagoCuota')->findBy(array('idDc'=>$id2));
        $curso=$this->getDoctrine()->getRepository('AppBundle:Curso')->find($id);
        $count=0;
        if($request->isMethod("POST")) {
            $alumno=$this->getDoctrine()->getRepository('AppBundle:Alumno')->findOneBy(array('idUi'=>$this->getUser()));
            $inscrip=$this->getDoctrine()->getRepository('AppBundle:InscripcionCurso')->findOneBy(array('idCurso'=>$id,'idAlumno'=>$alumno->getIdAlumno()));
            $pago=$this->getDoctrine()->getRepository('AppBundle:PagoCuota')->findOneBy(array('idCuota'=>$request->get("cuota"), 'idDc'=>$inscrip->getIdDc()));
            if ($pago) {
                $this->MensajeFlash('error', 'Esta cuota ya fue pagada!');
                $inscrip=$this->getDoctrine()->getRepository('AppBundle:InscripcionCurso')->findOneBy(array('idCurso'=>$id,'idAlumno'=>$alumno->getIdAlumno()));
                $curso = $this->getDoctrine()->getRepository('AppBundle:Curso')->find($id);
                return $this->redirectToRoute('cuotas_curso_alumno', array('id'=>$curso->getIdCurso(),'id2'=>$inscrip->getIdDc()));
            } else {
                if ($_FILES["imagen"]["error"] > 0){
                    return new Response('Error en la subida de la imagen');
                }else {
                    if($this->infoTipoImagen('imagen')[0]=='image') {
                        $p = new PagoCuota();
                        $cuo=$em->getRepository('AppBundle:Cuotas')->find($request->get('cuota'));
                        $nombrerecibo=$cuo->getCuota().$this->getUser().$curso->getIdCurso().$this->infoTipoImagen('imagen')[1];
                        if($nombrerecibo!=NULL){
                            $p->setImagenRecibo("img/recibo/".$nombrerecibo);
                        }
                        $p->setIdDc($inscrip);
                        $p->setCuotaDiferenciada($request->get("dif"));
                        $p->setIdCuota($em->getRepository('AppBundle:Cuotas')->find($request->get('cuota')));
                        $p->setFechaPago(\DateTime::createFromFormat('d/m/Y',$request->get("fechapago")));
                        $p->setMontoPagado($request->get("monto"));
                        $p->setNumeroRecibo($request->get("numrecibo"));
                        $p->setVerificado('enviado');

                        $em->persist($p);
                        $em->flush();
                        //Subiendo la Imagen
                        $this->subirRecibo('imagen',$nombrerecibo);
                        $this->MensajeFlash('exito', 'Pago creado correctamente!');
                        $inscrip=$this->getDoctrine()->getRepository('AppBundle:InscripcionCurso')->findOneBy(array('idCurso'=>$id,'idAlumno'=>$alumno->getIdAlumno()));
                        $curso = $this->getDoctrine()->getRepository('AppBundle:Curso')->find($id);
                        return $this->redirectToRoute('cuotas_curso_alumno', array('id'=>$curso->getIdCurso(),'id2'=>$inscrip->getIdDc()));
                    }
                }
            }
        }
        return $this->render('AppBundle:Alumno/Cursos:cuotasCurso.html.twig', array('cuotas'=>$cuotas,'cuotasp'=>$cuotasp,'curso'=>$curso,'inscrip'=>$inscrip, 'pago'=>$pago));
    }

     //Metodo para editar un pago
    /**
     * @Route("/alumno/cuotas/{id}/{id2}/edit", name="cuotas_edit_alumno")
     */
    public function cuotasEditAction($id,$id2, Request $request)
    {
        $em=$this->getDoctrine()->getManager("default");
        $alumno=$this->getDoctrine()->getRepository('AppBundle:Alumno')->findOneBy(array('idUi'=>$this->getUser()));
        $cuotas=$this->getDoctrine()->getRepository('AppBundle:Cuotas')->findBy(array('idCurso'=>$id2));
        $pago=$this->getDoctrine()->getRepository('AppBundle:PagoCuota')->find($id);
        $curso=$this->getDoctrine()->getRepository('AppBundle:Curso')->find($id2);

        if($request->isMethod("POST")) {
                if ($_FILES["imagen"]["error"] > 0){
                    return new Response('Error en la subida de la imagen');
                }else {
                    if($this->infoTipoImagen('imagen')[0]=='image') {
                        $cuo=$em->getRepository('AppBundle:Cuotas')->find($request->get('cuota'));
                        $nombrerecibo=$cuo->getCuota().$this->getUser().$curso->getIdCurso().$this->infoTipoImagen('imagen')[1];
                        if($nombrerecibo!=NULL){
                            $pago->setImagenRecibo("img/recibo/".$nombrerecibo);
                        }
                        $pago->setCuotaDiferenciada($request->get("dif"));
                        $pago->setFechaPago(new \DateTime($request->get("fechapago")));
                        $pago->setMontoPagado($request->get("monto"));
                        $pago->setNumeroRecibo($request->get("numrecibo"));
                        $pago->setVerificado('enviado');
                        $pago->setObservacion('Revisado y enviado');
                        $em->flush();
                        //Subiendo la Imagen
                        $this->subirRecibo('imagen',$nombrerecibo);
                        $this->MensajeFlash('exito', 'Pago actualizado correctamente!');
                        $cuotas=$this->getDoctrine()->getRepository('AppBundle:Cuotas')->findBy(array('idCurso'=>$id2));
                        $alumno=$this->getDoctrine()->getRepository('AppBundle:Alumno')->findOneBy(array('idUi'=>$this->getUser()));
                        $inscrip=$this->getDoctrine()->getRepository('AppBundle:InscripcionCurso')->findOneBy(array('idCurso'=>$id2,'idAlumno'=>$alumno->getIdAlumno()));
                        $pago=$this->getDoctrine()->getRepository('AppBundle:PagoCuota')->findBy(array('idDc'=>$id));
                        $curso=$this->getDoctrine()->getRepository('AppBundle:Curso')->find($id2);
                        return $this->redirectToRoute('cuotas_curso_alumno', array('id'=>$curso->getIdCurso(),'id2'=>$inscrip->getIdDc()));
                    }
                }

        }
        return $this->render('AppBundle:Alumno/Cursos:cuotasCursoEdit.html.twig', array('cuotas'=>$cuotas,'curso'=>$curso, 'pago'=>$pago));
    }
}
