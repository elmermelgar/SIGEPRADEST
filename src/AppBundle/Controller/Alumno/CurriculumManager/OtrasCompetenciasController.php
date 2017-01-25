<?php

namespace AppBundle\Controller\Alumno\CurriculumManager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\OtrasCompetencias;
use AppBundle\Form\OtrasCompetenciasType;

/**
 * OtrasCompetencias controller.
 *
 * @Route("/secretaria/otrascompetencias")
 */
class OtrasCompetenciasController extends Controller
{

    /**
     * Lists all OtrasCompetencias entities.
     *
     * @Route("/to/{cur}", name="secretaria_otrascompetencias")
     * @Method("GET")
     * @Template("@App/Curriculum/OtrasCompetencias/index.html.twig")
     */
    public function indexAction($cur)
    {
        $em = $this->getDoctrine()->getManager();
        $_SESSION["Curriculum"] = $cur;
        $entities = $em->getRepository('AppBundle:OtrasCompetencias')->findByidCurriculum($cur);

        return array(
            'entities' => $entities,
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }
    /**
     * Creates a new OtrasCompetencias entity.
     *
     * @Route("/", name="secretaria_otrascompetencias_create")
     * @Method("POST")
     * @Template("AppBundle:Curriculum/OtrasCompetencias:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new OtrasCompetencias();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('secretaria_otrascompetencias_show', array('id' => $entity->getIdOc())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }

    /**
     * Creates a form to create a OtrasCompetencias entity.
     *
     * @param OtrasCompetencias $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(OtrasCompetencias $entity)
    {
        $form = $this->createForm(new OtrasCompetenciasType(), $entity, array(
            'action' => $this->generateUrl('secretaria_otrascompetencias_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new OtrasCompetencias entity.
     *
     * @Route("/new", name="secretaria_otrascompetencias_new")
     * @Method("GET")
     * @Template("@App/Curriculum/OtrasCompetencias/new.html.twig")
     */
    public function newAction()
    {
        $entity = new OtrasCompetencias();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }

    /**
     * Finds and displays a OtrasCompetencias entity.
     *
     * @Route("/{id}", name="secretaria_otrascompetencias_show")
     * @Method("GET")
     * @Template("@App/Curriculum/OtrasCompetencias/show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:OtrasCompetencias')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OtrasCompetencias entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }

    /**
     * Displays a form to edit an existing OtrasCompetencias entity.
     *
     * @Route("/{id}/edit", name="secretaria_otrascompetencias_edit")
     * @Method("GET")
     * @Template("@App/Curriculum/OtrasCompetencias/edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:OtrasCompetencias')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OtrasCompetencias entity.');
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
    * Creates a form to edit a OtrasCompetencias entity.
    *
    * @param OtrasCompetencias $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(OtrasCompetencias $entity)
    {
        $form = $this->createForm(new OtrasCompetenciasType(), $entity, array(
            'action' => $this->generateUrl('secretaria_otrascompetencias_update', array('id' => $entity->getIdOc())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr' => array('class' => 'btn btn-primary square-btn-adjust',
        )));
        return $form;
    }
    /**
     * Edits an existing OtrasCompetencias entity.
     *
     * @Route("/{id}", name="secretaria_otrascompetencias_update")
     * @Method("PUT")
     * @Template("AppBundle:Curriculum/OtrasCompetencias:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:OtrasCompetencias')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OtrasCompetencias entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('secretaria_otrascompetencias_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }
    /**
     * Deletes a OtrasCompetencias entity.
     *
     * @Route("/{id}", name="secretaria_otrascompetencias_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:OtrasCompetencias')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find OtrasCompetencias entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('secretaria_otrascompetencias',array('cur' => $_SESSION["Curriculum"])));
    }

    /**
     * Creates a form to delete a OtrasCompetencias entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('secretaria_otrascompetencias_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
