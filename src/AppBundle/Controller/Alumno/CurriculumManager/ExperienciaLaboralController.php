<?php

namespace AppBundle\Controller\Alumno\CurriculumManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\ExperienciaLaboral;
use AppBundle\Form\ExperienciaLaboralType;

/**
 * ExperienciaLaboral controller.
 *
 * @Route("/alumno/experiencialaboral")
 */
class ExperienciaLaboralController extends Controller
{

    /**
     * Lists all ExperienciaLaboral entities.
     *
     * @Route("/to/{cur}", name="alumno_experiencialaboral")
     * @Method("GET")
     * @Template("@App/Alumno/Curriculum/ExperienciaLaboral/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
//        $_SESSION["Curriculum"] = $cur;
        $entities = $em->getRepository('AppBundle:ExperienciaLaboral')->findByidCurriculum( $_SESSION["Curriculum"]);

        return array(
            'entities' => $entities,
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }
    /**
     * Creates a new ExperienciaLaboral entity.
     *
     * @Route("/", name="alumno_experiencialaboral_create")
     * @Method("POST")
     * @Template("@App/Alumno/Curriculum/ExperienciaLaboral/new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ExperienciaLaboral();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $entity->setFechaInicioEl(new \DateTime( preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$entity->getFechaInicioEl())) );
            $entity->setFechaFinEl( new \DateTime( preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$entity->getFechaFinEl())) );



            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('alumno_experiencialaboral_show', array('id' => $entity->getIdEl())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }

    /**
     * Creates a form to create a ExperienciaLaboral entity.
     *
     * @param ExperienciaLaboral $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ExperienciaLaboral $entity)
    {
        $form = $this->createForm(new ExperienciaLaboralType(), $entity, array(
            'action' => $this->generateUrl('alumno_experiencialaboral_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar' ,  'attr' => array('class' => 'btn btn-primary',
            'style' => "width: 30%")));

        return $form;
    }

    /**
     * Displays a form to create a new ExperienciaLaboral entity.
     *
     * @Route("/new", name="alumno_experiencialaboral_new")
     * @Method("GET")
     * @Template("@App/Alumno/Curriculum/ExperienciaLaboral/new.html.twig")
     */
    public function newAction()
    {
        $entity = new ExperienciaLaboral();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }

    /**
     * Finds and displays a ExperienciaLaboral entity.
     *
     * @Route("/{id}", name="alumno_experiencialaboral_show")
     * @Method("GET")
     * @Template("@App/Alumno/Curriculum/ExperienciaLaboral/show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ExperienciaLaboral')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExperienciaLaboral entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }

    /**
     * Displays a form to edit an existing ExperienciaLaboral entity.
     *
     * @Route("/{id}/edit", name="alumno_experiencialaboral_edit")
     * @Method("GET")
     * @Template("@App/Alumno/Curriculum/ExperienciaLaboral/edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ExperienciaLaboral')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExperienciaLaboral entity.');
        }

        $entity->setFechaInicioEl($entity->getFechaInicioEl()->format('d-m-Y') );
        $entity->setFechaFinEl($entity->getFechaFinEl()->format('d-m-Y'));


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
    * Creates a form to edit a ExperienciaLaboral entity.
    *
    * @param ExperienciaLaboral $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ExperienciaLaboral $entity)
    {
        $form = $this->createForm(new ExperienciaLaboralType(), $entity, array(
            'action' => $this->generateUrl('alumno_experiencialaboral_update', array('id' => $entity->getIdEl())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr' => array('class' => 'btn btn-primary square-btn-adjust',
        )));

        return $form;
    }
    /**
     * Edits an existing ExperienciaLaboral entity.
     *
     * @Route("/{id}", name="alumno_experiencialaboral_update")
     * @Method("PUT")
     * @Template("@App/Alumno/Curriculum/ExperienciaLaboral/edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ExperienciaLaboral')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExperienciaLaboral entity.');
        }
        // aca tenemos que ver como ponemos en el formato correcto la cadena para guardar !!!!!!!!!!!!!!1
//echo "asd"; var_dump( $entity->getFechaInicioEl());
   //     var_dump( preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$entity->getFechaInicioEl()));

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $entity->setFechaInicioEl( new \DateTime( preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$entity->getFechaInicioEl())) );
            $entity->setFechaFinEl( new \DateTime( preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$entity->getFechaFinEl())) );

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('alumno_experiencialaboral_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'curriculum'=> $_SESSION["Curriculum"],
        );
    }
    /**
     * Deletes a ExperienciaLaboral entity.
     *
     * @Route("/{id}", name="alumno_experiencialaboral_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:ExperienciaLaboral')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ExperienciaLaboral entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('alumno_experiencialaboral',array('cur' => $_SESSION["Curriculum"])));
    }

    /**
     * Creates a form to delete a ExperienciaLaboral entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('alumno_experiencialaboral_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar', 'attr' => array('class' => 'btn btn-danger square-btn-adjust')))
            ->getForm()
        ;
    }
}
