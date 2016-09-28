<?php

namespace AppBundle\Controller\Interesado;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Cita;
use AppBundle\Form\CitaType;

/**
 * Cita controller.
 *
 * @Route("/Interesado/cita")
 */
class CitaController extends Controller
{

    /**
     * Lists all Cita entities.
     *
     * @Route("/", name="cita")
     * @Method("GET")
     * @Template("@App/Interesado/Cita/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Cita')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Cita entity.
     *
     * @Route("/", name="cita_create")
     * @Method("POST")
     * @Template("@App/Interesado/Cita/new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Cita();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cita_show', array('id' => $entity->getIdCita())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Cita entity.
     *
     * @param Cita $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Cita $entity)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();


        $form = $this->createForm(new CitaType(), $entity, array(
            'action' => $this->generateUrl('cita_create'),
            'method' => 'POST',
            'user'=> $user

        ));

        $form->add('submit', 'submit', array('label' => 'Guardar','attr'=>array('class'=>'btn btn-primary',
            'style'=>"width: 30%" )));

        return $form;
    }

    /**
     * Displays a form to create a new Cita entity.
     *
     * @Route("/new", name="cita_new")
     * @Method("GET")
     * @Template("@App/Interesado/Cita/new.html.twig")
     */
    public function newAction()
    {
        $entity = new Cita();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Cita entity.
     *
     * @Route("/{id}", name="cita_show")
     * @Method("GET")
     * @Template("@App/Interesado/Cita/show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Cita')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cita entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Cita entity.
     *
     * @Route("/{id}/edit", name="cita_edit")
     * @Method("GET")
     * @Template("@App/Interesado/Cita/edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Cita')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cita entity.');
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
    * Creates a form to edit a Cita entity.
     *  $user = $this->container->get('security.context')->getToken()->getUser();
    echo $user;
    *
    * @param Cita $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Cita $entity)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new CitaType(), $entity, array(
            'action' => $this->generateUrl('cita_update', array('id' => $entity->getIdCita())),
            'method' => 'PUT',
            'user'=>$user
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr'=>array('class'=>'btn btn-primary',
            'style'=>"width: 100%" )));


        return $form;
    }
    /**
     * Edits an existing Cita entity.
     *
     * @Route("/{id}", name="cita_update")
     * @Method("PUT")
     * @Template("@App/Interesado/Cita/edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Cita')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cita entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cita_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Cita entity.
     *
     * @Route("/{id}", name="cita_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Cita')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cita entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cita'));
    }

    /**
     * Creates a form to delete a Cita entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cita_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar','attr'=>array('class'=>'btn btn-danger',
                'style'=>"width: 100%;" )))
            ->getForm()
        ;
    }
}
