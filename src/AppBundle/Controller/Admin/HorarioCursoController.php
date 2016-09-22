<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\HorarioCurso;
use AppBundle\Form\HorarioCursoType;

/**
 * HorarioCurso controller.
 *
 * @Route("/horario_curso")
 */
class HorarioCursoController extends Controller
{

    /**
     * Lists all HorarioCurso entities.
     *
     * @Route("/", name="horario_curso")
     * @Method("GET")
     * @Template("AppBundle:Admin/HorarioCurso:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:HorarioCurso')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new HorarioCurso entity.
     *
     * @Route("/", name="horario_curso_create")
     * @Method("POST")
     * @Template("AppBundle:Admin/HorarioCurso:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new HorarioCurso();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('horario_curso_show', array('id' => $entity->getIdHc())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a HorarioCurso entity.
     *
     * @param HorarioCurso $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(HorarioCurso $entity)
    {
        $form = $this->createForm(new HorarioCursoType(), $entity, array(
            'action' => $this->generateUrl('horario_curso_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new HorarioCurso entity.
     *
     * @Route("/new", name="horario_curso_new")
     * @Method("GET")
     *  @Template("AppBundle:Admin/HorarioCurso:new.html.twig")
     */
    public function newAction()
    {
        $entity = new HorarioCurso();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a HorarioCurso entity.
     *
     * @Route("/{id}", name="horario_curso_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:HorarioCurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HorarioCurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing HorarioCurso entity.
     *
     * @Route("/{id}/edit", name="horario_curso_edit")
     * @Method("GET")
     * @Template("AppBundle:Admin/HorarioCurso:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:HorarioCurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HorarioCurso entity.');
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
     * Creates a form to edit a HorarioCurso entity.
     *
     * @param HorarioCurso $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(HorarioCurso $entity)
    {
        $form = $this->createForm(new HorarioCursoType(), $entity, array(
            'action' => $this->generateUrl('horario_curso_update', array('id' => $entity->getIdHc())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing HorarioCurso entity.
     *
     * @Route("/{id}", name="horario_curso_update")
     * @Method("PUT")
     * @Template("AppBundle:Admin/HorarioCurso:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:HorarioCurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HorarioCurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('horario_curso_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a HorarioCurso entity.
     *
     * @Route("/{id}", name="horario_curso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:HorarioCurso')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find HorarioCurso entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('horario_curso'));
    }

    /**
     * Creates a form to delete a HorarioCurso entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('horario_curso_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
            ;
    }
}
