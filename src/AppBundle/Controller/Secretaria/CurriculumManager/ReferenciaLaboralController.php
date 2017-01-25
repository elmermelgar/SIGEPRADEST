<?php

namespace AppBundle\Controller\Secretaria\CurriculumManager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\ReferenciaLaboral;
use AppBundle\Form\ReferenciaLaboralType;

/**
 * ReferenciaLaboral controller.
 *
 * @Route("/secretaria/referencialaboral")
 */
class ReferenciaLaboralController extends Controller
{

    /**
     * Lists all ReferenciaLaboral entities.
     *
     * @Route("/to/{cur}", name="secretaria_referencialaboral")
     * @Method("GET")
     * @Template("@App/Curriculum/ReferenciaLaboral/index.html.twig")
     */
    public function indexAction($cur)
    {
        $em = $this->getDoctrine()->getManager();
        $_SESSION["Curriculum"] = $cur;
        $entities = $em->getRepository('AppBundle:ReferenciaLaboral')->findByidCurriculum($cur);

        return array(
            'entities' => $entities,
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }
    /**
     * Creates a new ReferenciaLaboral entity.
     *
     * @Route("/", name="secretaria_referencialaboral_create")
     * @Method("POST")
     * @Template("AppBundle:Curriculum/ReferenciaLaboral:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ReferenciaLaboral();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('secretaria_referencialaboral_show', array('id' => $entity->getIdRf())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }

    /**
     * Creates a form to create a ReferenciaLaboral entity.
     *
     * @param ReferenciaLaboral $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ReferenciaLaboral $entity)
    {
        $form = $this->createForm(new ReferenciaLaboralType(), $entity, array(
            'action' => $this->generateUrl('secretaria_referencialaboral_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ReferenciaLaboral entity.
     *
     * @Route("/new", name="secretaria_referencialaboral_new")
     * @Method("GET")
     * @Template("@App/Curriculum/ReferenciaLaboral/new.html.twig")
     */
    public function newAction()
    {
        $entity = new ReferenciaLaboral();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }

    /**
     * Finds and displays a ReferenciaLaboral entity.
     *
     * @Route("/{id}", name="secretaria_referencialaboral_show")
     * @Method("GET")
     * @Template("@App/Curriculum/ReferenciaLaboral/show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ReferenciaLaboral')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ReferenciaLaboral entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }

    /**
     * Displays a form to edit an existing ReferenciaLaboral entity.
     *
     * @Route("/{id}/edit", name="secretaria_referencialaboral_edit")
     * @Method("GET")
     * @Template("@App/Curriculum/ReferenciaLaboral/edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ReferenciaLaboral')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ReferenciaLaboral entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }

    /**
    * Creates a form to edit a ReferenciaLaboral entity.
    *
    * @param ReferenciaLaboral $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ReferenciaLaboral $entity)
    {
        $form = $this->createForm(new ReferenciaLaboralType(), $entity, array(
            'action' => $this->generateUrl('secretaria_referencialaboral_update', array('id' => $entity->getIdRf())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr' => array('class' => 'btn btn-primary square-btn-adjust',
        )));

        return $form;
    }
    /**
     * Edits an existing ReferenciaLaboral entity.
     *
     * @Route("/{id}", name="secretaria_referencialaboral_update")
     * @Method("PUT")
     * @Template("AppBundle:Curriculum/ReferenciaLaboral:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ReferenciaLaboral')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ReferenciaLaboral entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('secretaria_referencialaboral_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }
    /**
     * Deletes a ReferenciaLaboral entity.
     *
     * @Route("/{id}", name="secretaria_referencialaboral_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:ReferenciaLaboral')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ReferenciaLaboral entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('secretaria_referencialaboral',array('cur' => $_SESSION["Curriculum"])));
    }

    /**
     * Creates a form to delete a ReferenciaLaboral entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('secretaria_referencialaboral_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
