<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\HorarioEntrevista;
use AppBundle\Form\HorarioEntrevistaType;

/**
 * HorarioEntrevista controller.
 *
 * @Route("/horarioentrevista")
 */
class HorarioEntrevistaController extends Controller
{

    /**
     * Lists all HorarioEntrevista entities.
     *
     * @Route("/", name="horarioentrevista")
     * @Method("GET")
     * @Template("AppBundle:Admin/HorarioEntrevista:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:HorarioEntrevista')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new HorarioEntrevista entity.
     *
     * @Route("/", name="horarioentrevista_create")
     * @Method("POST")
     * @Template("AppBundle:Admin/HorarioEntrevista:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new HorarioEntrevista();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('horarioentrevista_show', array('id' => $entity->getIdHe())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a HorarioEntrevista entity.
     *
     * @param HorarioEntrevista $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(HorarioEntrevista $entity)
    {
        $form = $this->createForm(new HorarioEntrevistaType(), $entity, array(
            'action' => $this->generateUrl('horarioentrevista_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new HorarioEntrevista entity.
     *
     * @Route("/new", name="horarioentrevista_new")
     * @Method("GET")
     * @Template("AppBundle:Admin/HorarioEntrevista:new.html.twig")
     */
    public function newAction()
    {
        $entity = new HorarioEntrevista();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a HorarioEntrevista entity.
     *
     * @Route("/{id}", name="horarioentrevista_show")
     * @Method("GET")
     * @Template("AppBundle:Admin/HorarioEntrevista:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:HorarioEntrevista')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HorarioEntrevista entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing HorarioEntrevista entity.
     *
     * @Route("/{id}/edit", name="horarioentrevista_edit")
     * @Method("GET")
     * @Template("AppBundle:Admin/HorarioEntrevista:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:HorarioEntrevista')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HorarioEntrevista entity.');
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
    * Creates a form to edit a HorarioEntrevista entity.
    *
    * @param HorarioEntrevista $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(HorarioEntrevista $entity)
    {
        $form = $this->createForm(new HorarioEntrevistaType(), $entity, array(
            'action' => $this->generateUrl('horarioentrevista_update', array('id' => $entity->getIdHe())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing HorarioEntrevista entity.
     *
     * @Route("/{id}", name="horarioentrevista_update")
     * @Method("PUT")
     * @Template("AppBundle:Admin/HorarioEntrevista:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:HorarioEntrevista')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HorarioEntrevista entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('horarioentrevista_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a HorarioEntrevista entity.
     *
     * @Route("/{id}", name="horarioentrevista_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:HorarioEntrevista')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find HorarioEntrevista entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('horarioentrevista'));
    }

    /**
     * Creates a form to delete a HorarioEntrevista entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('horarioentrevista_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
