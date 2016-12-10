<?php

namespace AppBundle\Controller\Secretaria;
use Proxies\__CG__\AppBundle\Entity\Curriculum;
use Proxies\__CG__\AppBundle\Entity\Expediente;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Alumno;
use AppBundle\Form\AlumnoType;

/**
 * Alumno controller.
 *
 * @Route("/secretaria/alumnos")
 */
class AlumnoController extends Controller
{

    /**
     * Lists all Alumno entities.
     *
     * @Route("/", name="alumnos")
     * @Method("GET")
     * @Template("@App/Secretaria/Alumno/newSolAproba.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        //usamos esta consulta para ver las solicitudes que no contienen usuarios. por lo que mostraremos solo solicitudes que tengan aspirantes
//        $entities = $em->createQuery('Select soli from AppBundle:Solicitud soli ')->getResult();
        $entities = $em->createQuery("SELECT so FROM AppBundle\Entity\Solicitud so, AppBundle\Entity\Curso cu
        WHERE so.idCurso=cu.idCurso AND so.estado='aprobada' AND cu.estadoCurso='disponible'")->getResult();

//        $entities = $em->getRepository('AppBundle:Solicitud')->findBy( array('name' => 'someValue'));
//  var_dump($entities[0]->getIdAlumno());
//      echo $entities[0];
        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all Alumno entities.
     *
     * @Route("/all", name="alumnosall")
     * @Method("GET")
     * @Template("@App/Secretaria/Alumno/index.html.twig")
     */
    public function indexallAction()
    {
        $em = $this->getDoctrine()->getManager();
        //usamos esta consulta para ver las solicitudes que no contienen usuarios. por lo que mostraremos solo solicitudes que tengan aspirantes
        $entities = $em->getRepository('AppBundle:Curriculum')->findAll();
//        $entities = $em->createQuery('Select soli,use from AppBundle:Solicitud soli JOIN soli.idUi use WHERE use.idRol = 4  ')->getResult();
//var_dump($entities[0]->getIdAlumno()->getIdUi());
//        $entities = $em->getRepository('AppBundle:Solicitud')->findBy( array('name' => 'someValue'));
//  var_dump($entities[0]->getIdAlumno());
//      echo $entities[0];
        return array(
            'entities' => $entities,
        );
    }





    /**
     * Creates a new Alumno entity.
     *
     * @Route("/", name="alumno_create")
     * @Method("POST")
     * @Template("AppBundle:Secretaria/Alumno:new.html.twig")
     */
    public function createAction(Request $request)
    {

        $entity = new Alumno();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('alumno_show', array('id' => $entity->getIdAlumno())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Alumno entity.
     *
     * @param Alumno $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Alumno $entity)
    {
        $form = $this->createForm(new AlumnoType(), $entity, array(
            'action' => $this->generateUrl('alumno_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/new", name="alumno_new")
     * @Method("GET")
     * @Template("@App/Secretaria/Alumno/new.html.twig")
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //obtenemos las variables de los header
        $idUsuario = $request->get("usuario");
        $idDatosPersonales =$request->get("datosPer");

        //obtenemos el numero de usuarios registrados el cual para ser insertado debe de ser cero
        $entityUsuario2 = $em->getRepository('AppBundle:Alumno')->findByidUi( $idUsuario);
        $numeroUsuarios = count( $entityUsuario2);

        if($numeroUsuarios== 0){

         // seteamoas las nueva entidades a guardar
        $entityCurruculum= new Curriculum();
        $entityAlumno = new Alumno();
        $entityExpediente = new Expediente();


        // obtenemos las entidadedes
        $entityUsuario = $em->getRepository('AppBundle:Usuario')->find( $idUsuario);
        $entityDatosPer= $em->getRepository('AppBundle:DatosPersonales')->find( $idDatosPersonales);
        $rolFromEntity =$em->getRepository('AppBundle:Roles')->find(3);
        //obtenemos el numero de usuarios registrados el cual para ser insertado debe de ser cero


//var_dump( count( $entityUsuario2));
//var_dump($entityUsuario);
//var_dump($entityDatosPer);

        //seteamos los datos personales
        $entityUsuario->setIdRol($rolFromEntity);

        // seteamos el entity alumno
        $entityAlumno->setEstadoAlumno("activo");
        $entityAlumno->setIdUi($entityUsuario);
        $entityAlumno->setIdDp($entityDatosPer);

            $entityCurruculum->setIdAlumno($entityAlumno);
            $entityExpediente->setIdAlumno($entityAlumno);

         // se le pondran fechas por defecto para que pueda ser leido desde la edicion
            $date = new \DateTime("now");
            $entityExpediente->setFechaExpTitulo($date);
            $entityExpediente->setFechaNaci($date);
            $entityExpediente->setFechaRegistro($date);
            $entityExpediente->setFechaTitulacion($date);
            $entityExpediente->setTipoEstudiante("1");

        $em->persist($entityAlumno);
        $em->persist($entityCurruculum);
        $em->persist($entityExpediente);


            $em->flush();


//            var_dump($entityAlumno->getIdDp());
            return array(
                'exito' => "Usuario guardado correctamente",
                'general'   => "Saludos",
                'idDatosPerson'   => $entityAlumno->getIdDp()->getIdDp(),
                'idAlum'   => $entityAlumno->getIdAlumno(),
                'curriculum'   => $entityCurruculum->getIdCurriculum(),
                'expediente'   => $entityExpediente->getIdExp(),
            );
        }else{

            return $this->redirect($this->generateUrl('alumno', array('resultado' => "error al crecar")));

        }



//

    }

    /**
     * Finds and displays a Alumno entity.
     *
     * @Route("/{id}", name="alumno_show")
     * @Method("GET")
     * @Template("@App/Secretaria/Alumno/show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Alumno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alumno entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Alumno entity.
     *
     * @Route("/{id}/edit", name="alumno_edit")
     * @Method("GET")
     * @Template("@App/Secretaria/Alumno/edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Alumno')->findOneByidDp($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alumno entity.');
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
    * Creates a form to edit a Alumno entity.
    *
    * @param Alumno $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Alumno $entity)
    {
        $form = $this->createForm(new AlumnoType(), $entity, array(
            'action' => $this->generateUrl('alumno_update', array('id' => $entity->getIdAlumno())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Alumno entity.
     *
     * @Route("/{id}", name="alumno_update")
     * @Method("PUT")
     * @Template("AppBundle:Alumno:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Alumno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alumno entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('alumno_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Alumno entity.
     *
     * @Route("/{id}", name="alumno_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Alumno')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Alumno entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('alumno'));
    }

    /**
     * Creates a form to delete a Alumno entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('alumno_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
