<?php

namespace AppBundle\Controller\Interesado;

use AppBundle\Controller\SecurityController;
use AppBundle\Entity\DatosPersonales;
use AppBundle\Entity\InformacionAcademica;
use AppBundle\Entity\Solicitud;
use AppBundle\Entity\Usuario;
use AppBundle\Form\InformacionAcademicaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\DatosPersonalesType;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @Route("/interesado")
 */
class InteresadoController extends SecurityController
{
    /**
     * @Route("/", name="index_interesado")
     */
    public function indexAction(Request $request)
    {
        $cursos = null;
        //Recuperando los cursos disponibles
        $repository = $this->getDoctrine()->getRepository('AppBundle:Curso');
        $cursos = $repository->findBy(
            array('estadoCurso' => 'disponible')
        );

        return $this->render('AppBundle:Interesado:index.html.twig', array('cursos' => $cursos));
    }


    /**
     * @Route("/perfil", name="interesado_perfil")
     */
    public function perfilAction(Request $request)
    {
        //getting user
        $usuario = $this->getUser();
        //Recuperar perfil
        $repository = $this->getDoctrine()->getRepository('AppBundle:DatosPersonales');
        $perfil = $repository->findOneBy(
            array('idUi' => $usuario->getIdUi())
        );
        if ($perfil) {
            //Mostrar perfil
            return $this->redirectToRoute('perfil_edit');
        } else {
            //Crear nuevo perfil
            $perfil = new DatosPersonales();
            $perfil->setIdUi($usuario);
            $perfil->setCorreo($usuario->getCorreo());
            $form = $this->createCreateForm($perfil);
            return $this->render('AppBundle:Interesado/Perfil:miperfil.html.twig', array('form' => $form->createView()));
        }
    }

    private function createCreateForm(DatosPersonales $entity)
    {
        $form = $this->createForm(new DatosPersonalesType(), $entity, array(
            'action' => $this->generateUrl('perfil_create'),
            'method' => 'POST'
        ));
        return $form;
    }

    /**
     * @Route("/perfil/create", name="perfil_create")
     */
    public function createAction(Request $request)
    {
        $perfil = new DatosPersonales();
        $form = $this->createCreateForm($perfil);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $perfil->setIdUi($this->getUser());
            $em->persist($perfil);
            $em->flush();
            $this->MensajeFlash('exito', 'Se ha creado el perfil personal.');
            return $this->redirectToRoute('index_interesado');
        }
        return $this->render('AppBundle:Interesado/Perfil:miperfil.html.twig', array('form' => $form->createView()));
    }


    /**
     * @Route("/perfil/edit", name="perfil_edit")
     */
    public function editAction(Request $request)
    {
        //getting user
        $usuario = $this->getUser();
        //Recuperar perfil
        $repository = $this->getDoctrine()->getRepository('AppBundle:DatosPersonales');
        $perfil = $repository->findOneBy(
            array('idUi' => $usuario->getIdUi())
        );
        if ($perfil) {
            //Mostrar perfil
            $form = $this->createEditForm($perfil);
            return $this->render('AppBundle:Interesado/Perfil:edit.html.twig', array('perfil' => $perfil, 'form' => $form->createView()));
        } else {
            return $this->redirectToRoute('index_interesado');
        }
    }

    private function createEditForm(DatosPersonales $entity)
    {
        $form = $this->createForm(new DatosPersonalesType(), $entity, array(
            'action' => $this->generateUrl('perfil_update'),
            //array('id' => $entity->getIdDp()),
            'method' => 'PUT'
        ));
        return $form;
    }

    /**
     * @Route("/perfil/update", name="perfil_update")
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $perfil = $em->getRepository('AppBundle:DatosPersonales')->findOneBy(
            array('idUi' => $this->getUser()->getIdUi())
        );
        $form = $this->createEditForm($perfil);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();
            $this->MensajeFlash('exito', 'Se ha actualizado el perfil personal.');
            //return $this->redirectToRoute('index_interesado');
            return $this->redirectToRoute('perfil_edit');
        }
        $this->MensajeFlash('error', 'Revise los datos del perfil.');
        return $this->render('AppBundle:Interesado/Perfil:edit.html.twig', array('perfil' => $perfil, 'form' => $form->createView()));
    }

    /**
     * @Route("/solicitud/{idc}", name="interesado_solicitud")
     */
    public function solicitudAction($idc, Request $request)
    {
        //getting user
        $usuario = $this->getUser();
        //Recuperar perfil
        $repository = $this->getDoctrine()->getRepository('AppBundle:DatosPersonales');
        $perfil = $repository->findOneBy(
            array('idUi' => $usuario->getIdUi())
        );
        if ($perfil) {
            $reposol = $this->getDoctrine()->getRepository('AppBundle:Solicitud');
            ///$idc = $request->get('idc');
            $solicitud = $reposol->findOneBy(array(
                'idCurso' => $idc,
                'estado' => 'creada'
            ));
            if ($solicitud) {
                //Mostrar la solicitud
                //$this->MensajeFlash('exito','This feature is not supported yet!');
                //segun estado de la solicitud: editarla, msg-solicitud enviada

                //Curso
                $repoCurso = $this->getDoctrine()->getRepository('AppBundle:Curso');
                $curso = $repoCurso->findOneBy(
                    array('idCurso' => $idc)
                );
                //Informacion academica
                $repoia = $this->getDoctrine()->getRepository('AppBundle:InformacionAcademica');
                $infoacademica = $repoia->findBy(
                    array('idSolicitud' => $solicitud->getIdSolicitud())
                );
                return $this->render('AppBundle:Interesado/Solicitud:solicitud.html.twig', array(
                    'perfil' => $perfil,
                    'solicitud' => $solicitud,
                    'estudios' => $infoacademica,
                    'curso' => $curso
                ));
            } else {
                $repoCurso = $this->getDoctrine()->getRepository('AppBundle:Curso');
                $curso = $repoCurso->findOneBy(
                    array('idCurso' => $idc)
                );
                //Crear la solicitud
                $newSol = new Solicitud();
                $newSol->setIdUi($usuario);
                $newSol->setIdDp($perfil);
                $newSol->setIdCurso($curso);
                $newSol->setEstado('creada');
                $em = $this->getDoctrine()->getManager();
                $em->persist($newSol);
                $em->flush();

                //Informacion academica
                $repoia = $this->getDoctrine()->getRepository('AppBundle:InformacionAcademica');
                $infoacademica = $repoia->findBy(
                    array('idSolicitud' => $newSol->getIdSolicitud())
                );

                return $this->render('AppBundle:Interesado/Solicitud:solicitud.html.twig', array(
                    'perfil' => $perfil,
                    'solicitud' => $newSol,
                    'estudios' => $infoacademica,
                    'curso' => $curso
                ));
            }

        } else {
            //Crear nuevo perfil
            $this->MensajeFlash('error', 'Primero debe llenar su perfil');
            return $this->redirectToRoute('index_interesado');
        }
    }


    /**
     * @Route("/infoacademica/{idc}/{ids}", name="interesado_infoacademica")
     */
    public function newInfoAcademicaAction($idc, $ids, Request $request)
    {
        //Crear nueva info academica
        $info = new InformacionAcademica();
        $form = $this->createInfoAcademicaForm($info, $idc, $ids);
        return $this->render('AppBundle:Interesado/InfoAcademica:new.hmtl.twig', array(
            'ids' => $ids, 'idc' => $idc, 'form' => $form->createView()
        ));
    }

    private function createInfoAcademicaForm(InformacionAcademica $entity, $idc, $ids)
    {
        $form = $this->createForm(new InformacionAcademicaType(), $entity, array(
            'action' => $this->generateUrl('interesado_infoacademica_create', array('idc' => $idc, 'ids' => $ids)),
            'method' => 'POST'
        ));
        return $form;
    }

    /**
     * @Route("/infoacademica/create/{idc}/{ids}", name="interesado_infoacademica_create")
     */
    public function createInfoAcademicaAction($idc, $ids, Request $request)
    {
        $info = new InformacionAcademica();
        $form = $this->createInfoAcademicaForm($info, $idc, $ids);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //Get solicitud
            $reposol = $this->getDoctrine()->getRepository('AppBundle:Solicitud');
            $solicitud = $reposol->findOneBy(
                array('idSolicitud' => $ids)
            );
            $info->setIdSolicitud($solicitud);

            $em->persist($info);
            $em->flush();
            //$this->MensajeFlash('exito', 'Se ha creado un nuevo registro de informacion academica');
            return $this->redirectToRoute('interesado_solicitud', array('idc' => $idc));
        }
        return $this->render('AppBundle:Interesado/InfoAcademica:new.hmtl.twig', array(
            'idc' => $idc, 'ids' => $ids, 'form' => $form->createView()));
    }

    /**
     * @Route("/infoacademica/edit/{idc}/{idia}", name="interesado_infoacademica_edit")
     */
    public function editInfoAcademicaAction($idc, $idia, Request $request)
    {
        //Editar info academica
        $repoinfo = $this->getDoctrine()->getRepository('AppBundle:InformacionAcademica');
        $info = $repoinfo->findOneBy(
            array('idIfacad' => $idia)
        );
        $form = $this->createEditInfoAcademicaForm($info, $idc, $idia);
        return $this->render('AppBundle:Interesado/InfoAcademica:edit.html.twig', array('idc' => $idc, 'form' => $form->createView()));
    }

    private function createEditInfoAcademicaForm(InformacionAcademica $entity, $idc, $idia)
    {
        $form = $this->createForm(new InformacionAcademicaType(), $entity, array(
            'action' => $this->generateUrl('interesado_infoacademica_update', array('idc' => $idc, 'idia' => $idia)),
            'method' => 'POST'
        ));
        return $form;
    }

    /**
     * @Route("/infoacademica/update/{idc}/{idia}", name="interesado_infoacademica_update")
     */
    public function createEditInfoAcademicaAction($idc, $idia, Request $request)
    {
        $repoinfo = $this->getDoctrine()->getRepository('AppBundle:InformacionAcademica');
        $info = $repoinfo->findOneBy(
            array('idIfacad' => $idia)
        );
        //$idc = $request->get('idc');
        $form = $this->createEditInfoAcademicaForm($info, $idc, $idia);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            //$this->MensajeFlash('exito', 'Se ha actualizado el registro de información académica');
            return $this->redirectToRoute('interesado_solicitud', array('idc' => $idc));
        }
        $this->MensajeFlash('error', 'Verifque la información ingresada');
        return $this->render('AppBundle:Interesado/InfoAcademica:edit.hmtl.twig', array('idc' => $idc, 'form' => $form->createView()));
    }

    /**
     * @Route("/infoacademica/delete/{idia}/{idc}", name="interesado_infoacademica_delete")
     *
     */
    public function deleteInfoAcademicaAction($idia, $idc, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $info = $this->getDoctrine()->getRepository('AppBundle:InformacionAcademica')->find($idia);
        if (!$info) {
            $this->MensajeFlash('error', 'Error al tratar de eliminar el registro');
            return $this->redirectToRoute('interesado_solicitud', array('idc' => $idc));
        }else {
            $em->remove($info);
            $em->flush();
            $this->MensajeFlash('exito', 'Registro eliminado correctamente!');
            return $this->redirectToRoute('interesado_solicitud', array('idc' => $idc));
        }
    }

    /**
     * @Route("/solicitud/enviar/{ids}", name="interesado_solicitud_enviar")
     *
     */
    public function enviarSolicitudAction(Request $request, $ids)
    {
        $res = 'ERROR';
        $em = $this->getDoctrine()->getManager();
        $repoSol = $em->getRepository('AppBundle:Solicitud');
        $sol = $repoSol->findOneBy(array(
            'idSolicitud' => $ids
        ));
        //Save disponibilidad
        $sol->setRangoDisponibilidad($request->get("dispo"));
        $em->flush();
        //Debe tener solicitud creada
        if ($sol) {
            $info = $this->getDoctrine()->getRepository('AppBundle:InformacionAcademica')->findBy(
                array('idSolicitud' => $sol->getIdSolicitud())
            );
            //Debe tener por los menos un registro en informacion academica
            if ($info) {
                //$sol->setFechaRegistro((new \DateTime('now',new \DateTimeZone('America/El_Salvador')))->format("Y-m-d"));
                $sol->setFechaRegistro(new \DateTime('now',new \DateTimeZone('America/El_Salvador')));
                //enviar solicitud de ingreso
                $sol->setEstado('enviada');
                $em->flush();
                $res = 'OK';
            } else {
                $this->MensajeFlash('error', 'Debe ingresar información académica');
            }
        }
        if ($res == 'OK') {
            $this->MensajeFlash('exito', 'Su solicitud de ingreso ha sido enviada');
            return $this->redirectToRoute('index_interesado');
        } else {
            //Getting Informacion academica
            $repoia = $this->getDoctrine()->getRepository('AppBundle:InformacionAcademica');
            $infoacademica = $repoia->findBy(
                array('idSolicitud' => $ids)
            );

            return $this->redirectToRoute('interesado_solicitud', array(
                'idc' => $sol->getIdCurso()->getIdCurso()
            ));
        }
    }

    /**
     * @Route("/solicitudes/ver", name="interesado_sol_vertodas")
     *
     */
    public function verSolicitudesAction()
    {
        $usuario = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $sql = $em->createQuery("SELECT s FROM AppBundle\Entity\Solicitud s WHERE s.idUi = :usuario AND s.estado NOT IN ('creada') ORDER BY s.fechaRegistro DESC");
        $sql->setParameter('usuario',$usuario);
        $solicitudes = $sql->getResult();

        return $this->render('AppBundle:Interesado/Solicitud:verSolicitudes.html.twig', array('solicitudes' => $solicitudes));
    }

}
