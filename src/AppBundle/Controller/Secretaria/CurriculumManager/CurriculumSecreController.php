<?php

namespace AppBundle\Controller\Secretaria\CurriculumManager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Curriculum;
use AppBundle\Form\CurriculumType;

/**
 * Curriculum controller.
 *
 * @Route("/secretaria/curriculum")
 */
class CurriculumSecreController extends Controller
{

    /**
 * Lists all Curriculum entities.
 *
 * @Route("/to/{id}", name="curriculumTo")
 * @Method("GET")
 * @Template("@App/Curriculum/indexPersonal.html.twig")
 */
    public function indexToAction(Request $request)
    {
         $id=$request->get("id");
        //echo $id;
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Curriculum')->findAll();

        return array(
            'entities' => $entities,
            'curriculum' => $id,
        );
    }

    /**
     * Lists all Curriculum entities.
     *
     * @Route("/", name="curriculum")
     * @Method("GET")
     * @Template("@App/Curriculum/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Curriculum')->findAll();

        return array(
            'entities' => $entities,
        );
    }




    /**
     * Creates a new Curriculum entity.
     *
     * @Route("/", name="curriculum_create")
     * @Method("POST")
     * @Template("")
     */
    public function createAction(Request $request)
    {
        $entity = new Curriculum();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('curriculum_show', array('id' => $entity->getIdCurriculum())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Curriculum entity.
     *
     * @param Curriculum $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Curriculum $entity)
    {
        $form = $this->createForm(new CurriculumType(), $entity, array(
            'action' => $this->generateUrl('curriculum_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Curriculum entity.
     *
     * @Route("/new", name="curriculum_new")
     * @Method("GET")
     * @Template("@App/Curriculum/show.html.twig")
     */
    public function newAction()
    {
        $entity = new Curriculum();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Curriculum entity.
     *
     * @Route("/{id}", name="curriculum_show")
     * @Method("GET")
     * @Template("@App/Curriculum/show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Curriculum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Curriculum entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Curriculum entity.
     *
     * @Route("/{id}/edit", name="curriculum_edit")
     * @Method("GET")
     * @Template("@App/Curriculum/edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Curriculum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Curriculum entity.');
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
    * Creates a form to edit a Curriculum entity.
    *
    * @param Curriculum $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Curriculum $entity)
    {
        $form = $this->createForm(new CurriculumType(), $entity, array(
            'action' => $this->generateUrl('curriculum_update', array('id' => $entity->getIdCurriculum())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Curriculum entity.
     *
     * @Route("/{id}", name="curriculum_update")
     * @Method("PUT")
     * @Template("AppBundle:Curriculum:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Curriculum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Curriculum entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('curriculum_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Curriculum entity.
     *
     * @Route("/{id}", name="curriculum_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Curriculum')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Curriculum entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('curriculum'));
    }

    /**
     * Creates a form to delete a Curriculum entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('curriculum_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
