<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\TipoCurso;
use AppBundle\Form\TipoCursoType;

/**
 * TipoCurso controller.
 *
 * @Route("admin/tipocurso")
 */
class TipoCursoController extends Controller
{

    /**
     * Lists all TipoCurso entities.
     *
     * @Route("/", name="tipocurso")
     * @Method("GET")
     * @Template("AppBundle:Admin/TipoCurso:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:TipoCurso')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new TipoCurso entity.
     *
     * @Route("/", name="tipocurso_create")
     * @Method("POST")
     * @Template("AppBundle:Admin/TipoCurso:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new TipoCurso();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tipocurso_show', array('id' => $entity->getIdTc())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a TipoCurso entity.
     *
     * @param TipoCurso $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TipoCurso $entity)
    {
        $form = $this->createForm(new TipoCursoType(), $entity, array(
            'action' => $this->generateUrl('tipocurso_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TipoCurso entity.
     *
     * @Route("/new", name="tipocurso_new")
     * @Method("GET")
     * @Template("AppBundle:Admin/TipoCurso:new.html.twig")
     */
    public function newAction()
    {
        $entity = new TipoCurso();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a TipoCurso entity.
     *
     * @Route("/{id}", name="tipocurso_show")
     * @Method("GET")
     * @Template("AppBundle:Admin/TipoCurso:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:TipoCurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoCurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing TipoCurso entity.
     *
     * @Route("/{id}/edit", name="tipocurso_edit")
     * @Method("GET")
     * @Template("AppBundle:Admin/TipoCurso:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:TipoCurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoCurso entity.');
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
     * Creates a form to edit a TipoCurso entity.
     *
     * @param TipoCurso $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(TipoCurso $entity)
    {
        $form = $this->createForm(new TipoCursoType(), $entity, array(
            'action' => $this->generateUrl('tipocurso_update', array('id' => $entity->getIdTc())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }
    /**
     * Edits an existing TipoCurso entity.
     *
     * @Route("/{id}", name="tipocurso_update")
     * @Method("PUT")
     * @Template("AppBundle:Admin/TipoCurso:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:TipoCurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoCurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tipocurso_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a TipoCurso entity.
     *
     * @Route("/{id}", name="tipocurso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:TipoCurso')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TipoCurso entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tipocurso'));
    }

    /**
     * Creates a form to delete a TipoCurso entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipocurso_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-danger',
                'style' => "width: 100%;")))
            ->getForm()
            ;
    }
}
