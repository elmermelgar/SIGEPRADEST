<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\DetalleHorario;
use AppBundle\Form\DetalleHorarioType;

/**
 * DetalleHorario controller.
 *
 * @Route("/Admin/detallehorario")
 */
class DetalleHorarioController extends Controller
{

    /**
     * Lists all DetalleHorario entities.
     *
     * @Route("/", name="detallehorario")
     * @Method("GET")
     * @Template("@App/Admin/DetalleHorario/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:DetalleHorario')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new DetalleHorario entity.
     *
     * @Route("/", name="detallehorario_create")
     * @Method("POST")
     * @Template("AppBundle:Admin/DetalleHorario:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new DetalleHorario();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('detallehorario_show', array('id' => $entity->getIdDhe())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a DetalleHorario entity.
     *
     * @param DetalleHorario $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DetalleHorario $entity)
    {
        $form = $this->createForm(new DetalleHorarioType(), $entity, array(
            'action' => $this->generateUrl('detallehorario_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar' ,  'attr' => array('class' => 'btn btn-primary',
            'style' => "width: 30%")));

        return $form;
    }

    /**
     * Displays a form to create a new DetalleHorario entity.
     *
     * @Route("/new", name="detallehorario_new")
     * @Method("GET")
     * @Template("@App/Admin/DetalleHorario/new.html.twig")
     */
    public function newAction()
    {
        $entity = new DetalleHorario();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a DetalleHorario entity.
     *
     * @Route("/{id}", name="detallehorario_show")
     * @Method("GET")
     * @Template("@App/Admin/DetalleHorario/show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:DetalleHorario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DetalleHorario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing DetalleHorario entity.
     *
     * @Route("/{id}/edit", name="detallehorario_edit")
     * @Method("GET")
     * @Template("@App/Admin/DetalleHorario/edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:DetalleHorario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DetalleHorario entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a DetalleHorario entity.
    *
    * @param DetalleHorario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DetalleHorario $entity)
    {
        $form = $this->createForm(new DetalleHorarioType(), $entity, array(
            'action' => $this->generateUrl('detallehorario_update', array('id' => $entity->getIdDhe())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr' => array('class' => 'btn btn-primary',
        'style' => "width: 30%")));

        return $form;
    }
    /**
     * Edits an existing DetalleHorario entity.
     *
     * @Route("/{id}", name="detallehorario_update")
     * @Method("PUT")
     * @Template("AppBundle:Admin/DetalleHorario:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:DetalleHorario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DetalleHorario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('detallehorario_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a DetalleHorario entity.
     *
     * @Route("/{id}", name="detallehorario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:DetalleHorario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DetalleHorario entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('detallehorario'));
    }

    /**
     * Creates a form to delete a DetalleHorario entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('detallehorario_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar', 'attr' => array('class' => 'btn btn-danger',
                'style' => "width: 100%;")))
            ->getForm();
    }
}
