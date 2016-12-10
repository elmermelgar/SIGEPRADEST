<?php

namespace AppBundle\Controller\Alumno;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Expediente;
use AppBundle\Form\ExpedienteType;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Expediente controller.
 *
 * @Route("/alumnos/expediente")
 */
class ExpedienteController extends Controller
{

    /**
     * Lists all Expediente entities.
     *
     * @Route("/", name="alumno_expediente")
     * @Method("GET")
     * @Template("AppBundle:Alumno/Expediente:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Expediente')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Expediente entity.
     *
     * @Route("/", name="alumno_expediente_create")
     * @Method("POST")
     * @Template("AppBundle:Alumno/Expediente:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Expediente();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
         if ($form->isValid()) {
             var_dump(( preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$entity->getFechaRegistro())));

             $em = $this->getDoctrine()->getManager();
            $entity->setFechaTitulacion( new \DateTime( preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$entity->getFechaTitulacion())) );
            $entity->setFechaExpTitulo( new \DateTime( preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$entity->getFechaExpTitulo())) );
            $entity->setFechaNaci(  new \DateTime(preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$entity->getFechaNaci())) );
            $entity->setFechaRegistro( new \DateTime( preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$entity->getFechaRegistro())) );

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('alumno_expediente_show', array('id' => $entity->getIdExp())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Expediente entity.
     *
     * @param Expediente $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Expediente $entity)
    {
        $form = $this->createForm(new ExpedienteType(), $entity, array(
            'action' => $this->generateUrl('alumno_expediente_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Expediente entity.
     *
     * @Route("/new", name="alumno_expediente_new")
     * @Method("GET")
     * @Template("AppBundle:Alumno/Expediente:new.html.twig")
     */
    public function newAction()
    {
        $entity = new Expediente();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Expediente entity.
     *
     * @Route("/{id}", name="alumno_expediente_show")
     * @Method("GET")
     * @Template("AppBundle:Alumno/Expediente:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Expediente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Expediente entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Expediente entity.
     *
     * @Route("/{id}/editfromalum", name="alumno_expediente_edit_idAlum")
     * @Method("GET")
     * @Template("@App/Alumno/Expediente/edit.html.twig")
     */
    public function editActionFromAlum($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Expediente')->findOneByidAlumno($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Expediente entity.');
        }

        $entity->setFechaTitulacion($entity->getFechaTitulacion()->format('d-m-Y') );
        $entity->setFechaExpTitulo($entity->getFechaExpTitulo()->format('d-m-Y'));
        $entity->setFechaNaci(  $entity->getFechaNaci()->format('d-m-Y') );
        $entity->setFechaRegistro( $entity->getFechaRegistro()->format('d-m-Y') );
      //  var_dump($entity->getFechaRegistro()->format('d-m-Y') );
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }



    /**
     * Displays a form to edit an existing Expediente entity.
     *
     * @Route("/{id}/edit", name="alumno_expediente_edit")
     * @Method("GET")
     * @Template("@App/Alumno/Expediente/edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Expediente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Expediente entity.');
        }

        $entity->setFechaTitulacion($entity->getFechaTitulacion()->format('d-m-Y') );
        $entity->setFechaExpTitulo($entity->getFechaExpTitulo()->format('d-m-Y'));
        $entity->setFechaNaci(  $entity->getFechaNaci()->format('d-m-Y') );
        $entity->setFechaRegistro( $entity->getFechaRegistro()->format('d-m-Y') );
        //  var_dump($entity->getFechaRegistro()->format('d-m-Y') );
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }





    /**
    * Creates a form to edit a Expediente entity.
    *
    * @param Expediente $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Expediente $entity)
    {
        $form = $this->createForm(new ExpedienteType(), $entity, array(
            'action' => $this->generateUrl('alumno_expediente_update', array('id' => $entity->getIdExp())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr' => array('class' => 'btn btn-primary square-btn-adjust',
          )));

        return $form;
    }
    /**
     * Edits an existing Expediente entity.
     *
     * @Route("/{id}", name="alumno_expediente_update")
     * @Method("PUT")
     * @Template("AppBundle:Expediente:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Expediente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Expediente entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setFechaTitulacion( new \DateTime( preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$entity->getFechaTitulacion())) );
            $entity->setFechaExpTitulo( new \DateTime( preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$entity->getFechaExpTitulo())) );
            $entity->setFechaNaci(  new \DateTime(preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$entity->getFechaNaci())) );
            $entity->setFechaRegistro( new \DateTime( preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$entity->getFechaRegistro())) );




            $em->flush();

            return $this->redirect($this->generateUrl('alumno_expediente_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Expediente entity.
     *
     * @Route("/{id}", name="alumno_expediente_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Expediente')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Expediente entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('alumno_expediente'));
    }

    /**
     * Creates a form to delete a Expediente entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('alumno_expediente_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-primary square-btn-adjust')))
            ->getForm()
        ;
    }
}
