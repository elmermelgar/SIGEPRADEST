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
            /*
            $form = $this->createEditForm($perfil);
            return $this->render('AppBundle:Interesado/Perfil:edit.html.twig', array('form' => $form->createView()));
            */
            return $this->redirectToRoute('perfil_edit');
        } else {
            //Crear nuevo perfil
            $perfil = new DatosPersonales();
            $perfil->setIdUi($usuario);
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
     * @Route("/solicitud", name="interesado_solicitud")
     */
    public function solicitudAction(Request $request)
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
            $idc = $request->get('idc');
            $solicitud = $reposol->findOneBy(
                array('idCurso' => $idc)
            );
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
            $this->MensajeFlash('exito', 'Primero debe llenar su perfil');
            return $this->redirectToRoute('index_interesado');
        }
    }


    /**
     * @Route("/infoacademica", name="interesado_infoacademica")
     */
    public function newInfoAcademicaAction(Request $request)
    {
        //Crear nueva info academica
        $info = new InformacionAcademica();
        $form = $this->createInfoAcademicaForm($info, $request->get('idc'));
        return $this->render('AppBundle:Interesado/InfoAcademica:new.hmtl.twig', array('idc' => $request->get('idc'), 'form' => $form->createView()));
    }

    private function createInfoAcademicaForm(InformacionAcademica $entity, $idc)
    {
        $form = $this->createForm(new InformacionAcademicaType(), $entity, array(
            'action' => $this->generateUrl('interesado_infoacademica_create', array('idc' => $idc)),
            'method' => 'POST'
        ));
        return $form;
    }

    /**
     * @Route("/infoacademica/create", name="interesado_infoacademica_create")
     */
    public function createInfoAcademicaAction(Request $request)
    {
        $info = new InformacionAcademica();
        $idc = $request->get('idc');
        $form = $this->createInfoAcademicaForm($info, $idc);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //Get solicitud
            $reposol = $this->getDoctrine()->getRepository('AppBundle:Solicitud');
            $solicitud = $reposol->findOneBy(
                array('idCurso' => $idc)
            );
            $info->setIdSolicitud($solicitud);

            $em->persist($info);
            $em->flush();
            //$this->MensajeFlash('exito', 'Se ha creado un nuevo registro de informacion academica');
            return $this->redirectToRoute('interesado_solicitud', array('idc' => $idc));
        }
        return $this->render('AppBundle:Interesado/InfoAcademica:new.hmtl.twig', array('idc' => $idc, 'form' => $form->createView()));
    }

    /**
     * @Route("/infoacademica/edit", name="interesado_infoacademica_edit")
     */
    public function editInfoAcademicaAction(Request $request)
    {
        //Editar info academica
        $idc = $request->get('idc');
        $idia = $request->get('idia');
        $repoinfo = $this->getDoctrine()->getRepository('AppBundle:InformacionAcademica');
        $info = $repoinfo->findOneBy(
            array('idIfacad' => $idia)
        );
        $form = $this->createEditInfoAcademicaForm($info, $idc);
        return $this->render('AppBundle:Interesado/InfoAcademica:edit.html.twig', array('idc' => $idc, 'form' => $form->createView()));
    }

    private function createEditInfoAcademicaForm(InformacionAcademica $entity, $idc)
    {
        $form = $this->createForm(new InformacionAcademicaType(), $entity, array(
            'action' => $this->generateUrl('interesado_infoacademica_update', array('idc' => $idc)),
            'method' => 'POST'
        ));
        return $form;
    }

    /**
     * @Route("/infoacademica/update", name="interesado_infoacademica_update")
     */
    public function createEditInfoAcademicaAction(Request $request)
    {
        $info = new InformacionAcademica();
        $idc = $request->get('idc');
        $form = $this->createEditInfoAcademicaForm($info, $idc);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //Get solicitud
            $reposol = $this->getDoctrine()->getRepository('AppBundle:Solicitud');
            $solicitud = $reposol->findOneBy(
                array('idCurso' => $idc)
            );
            $info->setIdSolicitud($solicitud);

            $em->persist($info);
            $em->flush();
            $this->MensajeFlash('exito', 'Se ha actualizado el registro de información académica');
            return $this->redirectToRoute('interesado_solicitud', array('idc' => $idc));
        }
        $this->MensajeFlash('error', 'Verifque la información ingresada');
        return $this->render('AppBundle:Interesado/InfoAcademica:edit.hmtl.twig', array('idc' => $idc, 'form' => $form->createView()));
    }

    /**
     * @Route("/infoacademica/delete/{idia}/{idc}", name="interesado_infoacademica_delete")
     *
     */
    public function deleteInfoAcademicaAction($idia,$idc,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $info = $em->getRepository('AppBundle:InformacionAcademica')->find($idia);
        if(!$info){
            throw $this->createNotFoundException('No existe registro con el ID '.$idia);
        }
        $em->remove($info);
        $em->flush();
        $this->MensajeFlash('exito','Registro eliminado correctamente!');
        return $this->redirectToRoute('interesado_solicitud', array('idc' => $idc));
    }

}
