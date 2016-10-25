<?php

namespace AppBundle\Controller\Interesado;

use AppBundle\Controller\SecurityController;
use AppBundle\Entity\DatosPersonales;
use AppBundle\Entity\Usuario;
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
     * @Route("/solicitud", name="interesado_solicitud")
     */
    public function solicitudAction(Request $request){
        if($request->isMethod('POST')){
            //here code
            return $this->render('AppBundle:Interesado/Solicitud:solicitud.html.twig');
        }else{
            //here code
            return $this->render('AppBundle:Interesado/Solicitud:solicitud.html.twig');
        }
    }

    /**
     * @Route("/perfil", name="interesado_perfil")
     */
    public function perfilAction(Request $request){
        //getting user
        $usuario = $this->getUser();
        //Recuperar perfil
        $repository = $this->getDoctrine()->getRepository('AppBundle:DatosPersonales');
        $perfil = $repository->findOneBy(
            array('idUi' => $usuario->getIdUi())
        );
        if ($perfil){
            //Mostrar perfil
            /*
            $form = $this->createEditForm($perfil);
            return $this->render('AppBundle:Interesado/Perfil:edit.html.twig', array('form' => $form->createView()));
            */
            return $this->redirectToRoute('perfil_edit');
        }else{
            //Crear nuevo perfil
            $perfil = new DatosPersonales();
            $perfil->setIdUi($usuario);
            $form = $this->createCreateForm($perfil);
            return $this->render('AppBundle:Interesado/Perfil:miperfil.html.twig', array('form' => $form->createView()));
        }
    }

    private function createCreateForm(DatosPersonales $entity){
        $form = $this->createForm(new DatosPersonalesType(), $entity, array(
            'action' => $this->generateUrl('perfil_create'),
            'method' => 'POST'
        ));
        return $form;
    }

    /**
     * @Route("/perfil/create", name="perfil_create")
     */
    public function createAction(Request $request){
        $perfil = new DatosPersonales();
        $form = $this->createCreateForm($perfil);
        $form->handleRequest($request);
        if ($form->isValid()){
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
    public function editAction(Request $request){
        //getting user
        $usuario = $this->getUser();
        //Recuperar perfil
        $repository = $this->getDoctrine()->getRepository('AppBundle:DatosPersonales');
        $perfil = $repository->findOneBy(
            array('idUi' => $usuario->getIdUi())
        );
        if ($perfil){
            //Mostrar perfil
            $form = $this->createEditForm($perfil);
            return $this->render('AppBundle:Interesado/Perfil:edit.html.twig', array('perfil' => $perfil,'form' => $form->createView()));
        }else{
            return $this->redirectToRoute('index_interesado');
        }
    }

    private function createEditForm(DatosPersonales $entity){
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
    public function updateAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        //$perfil = new DatosPersonales();
        //$perfil = $em->getRepository('AppBundle:DatosPersonales')->find($request->get("id"));
        $perfil = $em->getRepository('AppBundle:DatosPersonales')->findOneBy(
            array('idUi' => $this->getUser()->getIdUi())
        );
        $form = $this->createEditForm($perfil);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $em->flush();
            $this->MensajeFlash('exito', 'Se ha actualizado el perfil personal.');
            //return $this->redirectToRoute('index_interesado');
            return $this->redirectToRoute('perfil_edit');
        }
        $this->MensajeFlash('error', 'Revise los datos del perfil.');
        return $this->render('AppBundle:Interesado/Perfil:edit.html.twig', array('perfil' => $perfil, 'form' => $form->createView()));
    }


}
