<?php

namespace AppBundle\Controller\Secretaria\CurriculumManager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Idioma;
use AppBundle\Form\IdiomaType;

/**
 * Idioma controller.
 *
 * @Route("/secretaria/idiomafromcur")
 */
class IdiomaController extends Controller
{

    /**
     * Lists all Idioma entities.
     *
     * @Route("/to/{cur}", name="idioma")
     * @Method("GET")
     * @Template("@App/Curriculum/Idioma/index.html.twig")
     */
    public function indexAction($cur)
    {
        $em = $this->getDoctrine()->getManager();
        $_SESSION["Curriculum"] = $cur;
        $entities = $em->getRepository('AppBundle:Idioma')->findByidCurriculum($cur);

        return array(
            'entities' => $entities,
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }
    /**
     * Creates a new Idioma entity.
     *
     * @Route("/", name="idioma_create")
     * @Method("POST")
     * @Template("AppBundle:Curriculum/Idioma:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Idioma();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('exito','Registro creado correctamente');
            return $this->redirect($this->generateUrl('idioma_show', array('id' => $entity->getIdIdioma())));
    }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }

    /**
     * Creates a form to create a Idioma entity.
     *
     * @param Idioma $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Idioma $entity)
    {
        $form = $this->createForm(new IdiomaType(), $entity, array(
            'action' => $this->generateUrl('idioma_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar' ,  'attr' => array('class' => 'btn btn-primary',
            'style' => "width: 30%")));
        return $form;
    }

    /**
     * Displays a form to create a new Idioma entity.
     *
     * @Route("/new", name="idioma_new")
     * @Method("GET")
     * @Template("@App/Curriculum/Idioma/new.html.twig")
     */
    public function newAction()
    {
        $entity = new Idioma();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }

    /**
     * Finds and displays a Idioma entity.
     *
     * @Route("/{id}", name="idioma_show")
     * @Method("GET")
     * @Template("@App/Curriculum/Idioma/show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Idioma')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Idioma entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }

    /**
     * Displays a form to edit an existing Idioma entity.
     *
     * @Route("/{id}/edit", name="idioma_edit")
     * @Method("GET")
     * @Template("@App/Curriculum/Idioma/edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Idioma')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Idioma entity.');
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
    * Creates a form to edit a Idioma entity.
    *
    * @param Idioma $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Idioma $entity)
    {
        $form = $this->createForm(new IdiomaType(), $entity, array(
            'action' => $this->generateUrl('idioma_update', array('id' => $entity->getIdIdioma())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr' => array('class' => 'btn btn-primary square-btn-adjust',
        )));

        return $form;
    }
    /**
     * Edits an existing Idioma entity.
     *
     * @Route("/{id}", name="idioma_update")
     * @Method("PUT")
     * @Template("AppBundle:Curriculum/Idioma:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Idioma')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Idioma entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add('exito','Registro actualizado correctamente');
            return $this->redirect($this->generateUrl('idioma_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }
    /**
     * Deletes a Idioma entity.
     *
     * @Route("/{id}", name="idioma_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Idioma')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Idioma entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        $this->get('session')->getFlashBag()->add('exito','Registro eliminado correctamente');
        return $this->redirect($this->generateUrl('idioma',array('cur' => $_SESSION["Curriculum"])));
    }

    /**
     * Creates a form to delete a Idioma entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('idioma_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar', 'attr' => array('class' => 'btn btn-danger square-btn-adjust')))
            ->getForm()
        ;
    }
}
