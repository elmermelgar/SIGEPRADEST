<?php

namespace AppBundle\Controller\Secretaria;

use AppBundle\Entity\Cuotas;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\SecurityController;

class CuotasController extends SecurityController
{
    /**
     * @Route("/secretaria/cuotas/{id}", name="cuotas")
     */
    public function cuotasViewsAction($id,Request $request){
        if($this->getUser()){
            $em2=$this->getDoctrine()->getManager("default");
            $cuotas=$em2->getRepository('AppBundle:Cuotas')->findBy(array('idCurso'=>$id));
            $curso=$em2->getRepository('AppBundle:Curso')->find($id);
            $contar=count($cuotas);
            return $this->render('AppBundle:Secretaria/Cuotas:cuotas_views.html.twig', array('cuotas'=>$cuotas, 'idcurso'=>$id, 'curso'=>$curso, 'contar'=>$contar));
        }
        else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/secretaria/cursosCuotas/", name="cursoscuotas")
     */
    public function cursosCuotasViewsAction(Request $request){
        if($this->getUser()){
            $em2=$this->getDoctrine()->getManager("default");
            $cursos=$em2->getRepository('AppBundle:Curso')->findAll();
            return $this->render('AppBundle:Secretaria/Cuotas:curso.html.twig', array('cursos'=>$cursos));
        }
        else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/secretaria/pagoCuotas/", name="pagocuotas")
     */
    public function pagoCuotasAction(Request $request){
        if($this->getUser()){
            $em2=$this->getDoctrine()->getManager("default");
            $pagos=$em2->getRepository('AppBundle:PagoCuota')->findAll();
            return $this->render('AppBundle:Secretaria/Cuotas:pagos.html.twig', array('pago'=>$pagos));
        }
        else{
            return $this->redirectToRoute('login');
        }
    }
    /**
     * @Route("/secretaria/verPago/{id}", name="verpago")
     */
    public function pagoCuotasViewsAction($id,Request $request){
        if($this->getUser()){
            $em2=$this->getDoctrine()->getManager("default");
            $pagos=$em2->getRepository('AppBundle:PagoCuota')->find($id);
            if($request->isMethod("POST")) {
                $pagos->setVerificado($request->get('orden'));
                $pagos->setObservacion($request->get('observacion'));

                $em2->flush();
                $this->MensajeFlash('exito', 'Condicion guardada correctamente!');
                return $this->redirectToRoute('pagocuotas');
            }
            return $this->render('AppBundle:Secretaria/Cuotas:pagos_ver.html.twig', array('pago'=>$pagos));
        }
        else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/secretaria/cuotas/create/{id}", name="cuotas_create")
     */
    public function cuotasCreateAction($id,Request $request){
        if($this->getUser()){
            $em2=$this->getDoctrine()->getManager("default");
            $unidades=$em2->getRepository('AppBundle:UnidadPresupuesto')->findAll();
            $linea=$em2->getRepository('AppBundle:LineaTrabajo')->findAll();
            $especifico=$em2->getRepository('AppBundle:Especifico')->findAll();
            $pago=$em2->getRepository('AppBundle:Pago')->findAll();
            $cuenta=$em2->getRepository('AppBundle:CuentaBanco')->findAll();
            if($request->isMethod("POST")) {
                $cuota=$em2->getRepository('AppBundle:Cuotas')->findOneBy(array('cuota'=>$request->get("nombrecuota"),'idCurso'=>$id));
                if ($cuota) {
                    $this->MensajeFlash('error', 'Ya existe una cuota con este nombre!');
                    return $this->render('AppBundle:Secretaria/Cuotas:cuota_create.html.twig', array('unidad' => $unidades, 'linea' => $linea, 'especifico' => $especifico, 'pago' => $pago, 'cuenta' => $cuenta, 'idcurso' => $id));
                } else {
                    $c=new Cuotas();
                    $c->setCuota($request->get("nombrecuota"));
                    $c->setDescripCuota($request->get("des_cuota"));
                    $c->setIdCuentaBanco($em2->getRepository('AppBundle:CuentaBanco')->find($request->get('cuenta')));
                    $curso = $em2->getRepository('AppBundle:Curso')->find($id);
                    $c->setIdCurso($curso);
                    $c->setIdLineaTrabajo($em2->getRepository('AppBundle:LineaTrabajo')->findOneBy(array('idLineaTrabajo'=>$request->get('linea'))));
                    $c->setIdPago($em2->getRepository('AppBundle:Pago')->find($request->get('pago')));
                    $c->setMonto($request->get('monto'));

                    $em2->persist($c);
                    $em2->flush();
                    $this->MensajeFlash('exito', 'Cuota creada correctamente!');
                    $cuotas=$em2->getRepository('AppBundle:Cuotas')->findBy(array('idCurso'=>$id));
                    $contar=count($cuotas);
                    return $this->render('AppBundle:Secretaria/Cuotas:cuotas_views.html.twig', array('cuotas'=>$cuotas, 'curso' => $curso, 'idcurso'=>$id, 'contar'=>$contar));
                }
            }
            return $this->render('AppBundle:Secretaria/Cuotas:cuota_create.html.twig', array('unidad'=>$unidades, 'linea'=>$linea, 'especifico'=>$especifico, 'pago'=>$pago, 'cuenta'=>$cuenta, 'idcurso'=>$id));
        }
        else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/secretaria/cuotas/{id}/{id2}/edit", name="cuotas_edit")
     */
    public function cuotasEditAction($id,$id2,Request $request){
        if($this->getUser()){
            $em2=$this->getDoctrine()->getManager("default");
            $unidades=$em2->getRepository('AppBundle:UnidadPresupuesto')->findAll();
            $linea=$em2->getRepository('AppBundle:LineaTrabajo')->findAll();
            $especifico=$em2->getRepository('AppBundle:Especifico')->findAll();
            $pago=$em2->getRepository('AppBundle:Pago')->findAll();
            $cuenta=$em2->getRepository('AppBundle:CuentaBanco')->findAll();
            $c=$em2->getRepository('AppBundle:Cuotas')->find($id);
            if($request->isMethod("POST")) {
                $cuota=$em2->getRepository('AppBundle:Cuotas')->findOneBy(array('cuota'=>$request->get("nombrecuota"),'idCurso'=>$id2));
                if ($cuota) {
                    $this->MensajeFlash('error', 'Ya existe una cuota con este nombre!');
                    return $this->render('AppBundle:Secretaria/Cuotas:cuota_edit.html.twig', array('unidad'=>$unidades, 'linea'=>$linea, 'especifico'=>$especifico, 'pago'=>$pago, 'cuenta'=>$cuenta, 'idcurso'=>$id2, 'cuota'=>$c));
                }
                    $c->setCuota($request->get("nombrecuota"));
                    $c->setDescripCuota($request->get("des_cuota"));
                    $c->setIdCuentaBanco($em2->getRepository('AppBundle:CuentaBanco')->find($request->get('cuenta')));
                    $c->setIdLineaTrabajo($em2->getRepository('AppBundle:LineaTrabajo')->findOneBy(array('idLineaTrabajo'=>$request->get('linea'))));
                    $c->setIdPago($em2->getRepository('AppBundle:Pago')->find($request->get('pago')));
                    $c->setMonto($request->get('monto'));
                    $em2->flush();
                    $this->MensajeFlash('exito', 'Cuota actualizada correctamente!');
                $cuotas=$em2->getRepository('AppBundle:Cuotas')->findBy(array('idCurso'=>$id));
                $curso=$em2->getRepository('AppBundle:Curso')->find($id2);
                $contar=count($cuotas);
                return $this->redirectToRoute('cursoscuotas');
//                return $this->render('AppBundle:Secretaria/Cuotas:cuotas_views.html.twig', array('cuotas'=>$cuotas, 'idcurso'=>$id, 'curso'=>$curso, 'contar'=>$contar));

            }
            return $this->render('AppBundle:Secretaria/Cuotas:cuota_edit.html.twig', array('unidad'=>$unidades, 'linea'=>$linea, 'especifico'=>$especifico, 'pago'=>$pago, 'cuenta'=>$cuenta, 'idcurso'=>$id2, 'cuota'=>$c));
        }
        else{
            return $this->redirectToRoute('login');
        }
    }

}
