<?php

namespace AppBundle\Controller\Alumno\CurriculumManager;

use AppBundle\Entity\Curriculum;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\FormacionAcademica;
use AppBundle\Form\FormacionAcademicaType;

/**
 * FormacionAcademica controller.
 *
 * @Route("/alumno/formacionacademica")
 */
class FormacionAcademicaController extends Controller
{

    /**
     * Lists all FormacionAcademica entities.
     *
     * @Route("/", name="alumnoformacionacademica")
     * @Method("GET")
     * @Template("@App/Curriculum/FormacionAcademica/index.html.twig")
     */
    public function indexAction()
    {


        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:FormacionAcademica')->findAll();

       return array(
            'entities' => $entities,

        );
    }
    /**
     * Lists all FormacionAcademica entities.
     *
     * @Route("/curriculum/{cur}", name="alumnoformacionacademicaCurriculum")
     * @Method("GET")
     * @Template("@App/alumno/Curriculum/FormacionAcademica/indexCurriculum.html.twig")
     */
    public function indexCurriculumAction()
    {
         $em = $this->getDoctrine()->getManager();
        $cur   = $_SESSION["Curriculum"];
        $entities = $em->getRepository('AppBundle:FormacionAcademica')->findByidCurriculum($cur);
//        $entitieCurriSeleted = $em->getRepository('AppBundle:Curriculum')->find($cur);

        return array(
            'entities' => $entities,
            'curriculum'=>  $cur,

        );
    }

    /**
     * Creates a new FormacionAcademica entity.
     *
     * @Route("/", name="alumnoformacionacademica_create")
     * @Method("POST")
     * @Template("AppBundle:alumno/Curriculum/FormacionAcademica:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new FormacionAcademica();
        $cur = $request->get("curriculum");
    //    var_dump($cur); var_dump("-----------------");
        $form = $this->createCreateForm($entity,$cur);
        $form->handleRequest($request);

        if ($form->isValid()) {
//----------------------------------------inicio de File
            //obtenemos la imagen que subimos desde el form
            $file = $entity->getImgTitulo();

            //seteamos las variables de destino del doc, el nuevo nombre que tendra, y su ruta de acceso
            $dirDestino = $_SERVER['DOCUMENT_ROOT'] . "\\public\\img\\formacion\\";
            $nombreArchivo = $file->getClientOriginalName();

            //echo $dirDestino."    -     ".$nombreArchivo;

            //efectuamos el movimiento
            $file->move($dirDestino, $nombreArchivo);
            //obtenemos los binarios de nuestra imgen a traves de la ruta especificada

            //metemos los binarios de data en la entidad
            $entity->setImgTitulo("../../../public/img/formacion/" . $nombreArchivo);

//          persistimos-----------------------------------fin de file-----------------


            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('alumnoformacionacademica_show', array('id' => $entity->getIdFa(),'curriculum'=>$cur )));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a FormacionAcademica entity.
     *
     * @param FormacionAcademica $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(FormacionAcademica $entity, $cur)
    {
       // var_dump($cur);
        $form = $this->createForm(new FormacionAcademicaType(), $entity, array(
            'action' => $this->generateUrl('alumnoformacionacademica_create',array('curriculum'=>$cur )),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new FormacionAcademica entity.
     *
     * @Route("/new", name="alumnoformacionacademica_new")
     * @Method("GET")
     * @Template("@App/alumno/Curriculum/FormacionAcademica/new.html.twig")
     */
    public function newAction(Request $request)
    {
        $cur = $request->get("curriculum");
        $entity = new FormacionAcademica();
        $form = $this->createCreateForm($entity,$cur);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'curriculum'=>$cur,
        );
    }

    /**
     * Finds and displays a FormacionAcademica entity.
     *
     * @Route("/{id}", name="alumnoformacionacademica_show")
     * @Method("GET")
     * @Template("@App/alumno/Curriculum/FormacionAcademica/show.html.twig")
     */
    public function showAction($id,Request $request)
    {
        $cur = $request->get("curriculum");
     //   var_dump("sss\n");

       // var_dump($cur);
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:FormacionAcademica')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FormacionAcademica entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
            'curriculum'=>$cur,
        );
    }

    /**
     * Displays a form to edit an existing FormacionAcademica entity.
     *
     * @Route("/{id}/edit", name="alumnoformacionacademica_edit")
     * @Method("GET")
     * @Template("@App/alumno/Curriculum/FormacionAcademica/edit.html.twig")
     */
    public function editAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cur = $request->get("curriculum");
        $entity = $em->getRepository('AppBundle:FormacionAcademica')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FormacionAcademica entity.');
        }

        $editForm = $this->createEditForm($entity,$cur);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'curriculum'=>$cur,
        );
    }

    /**
     * Creates a form to edit a FormacionAcademica entity.
     *
     * @param FormacionAcademica $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(FormacionAcademica $entity,$cur)
    {
//       transformamos la direccion en la base a un FILE para que pueda ser mostrado
        $cadenaArchvo = str_replace('/', '\\', str_replace('../../..', '', $entity->getImgTitulo()));
        $rutaArchivo = $_SERVER['DOCUMENT_ROOT'] . $cadenaArchvo;

        $entity->setImgTitulo(new File($rutaArchivo));
        // var_dump( $entity->getImgTitulo()->isValid());array('curriculum'=>$cur )
        $form = $this->createForm(new FormacionAcademicaType(), $entity, array(
            'action' => $this->generateUrl('alumnoformacionacademica_update', array('curriculum'=>$cur,'id' => $entity->getIdFa())),
            'method' => 'PUT',
        ));
//        $form->remove('imgTitulo');
        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing FormacionAcademica entity.
     *
     * @Route("/{id}", name="alumnoformacionacademica_update")
     * @Method("PUT")
     * @Template("AppBundle:alumno/Curriculum/FormacionAcademica:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $cur = $request->get("curriculum");
        $entity = $em->getRepository('AppBundle:FormacionAcademica')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FormacionAcademica entity.');
        }

        $exArchivo = $entity->getImgTitulo();

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity,$cur);


        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            if ($editForm['imgTitulo']->getData() == null)
                $entity->setImgTitulo($exArchivo);
            else {
                //obtenemos la imagen que subimos desde el form
//-------ELIMINACION DE ARCHIVO---------seteamos las variables de destino del doc, el nuevo nombre que tendra, y su ruta de acceso
                $cadenaArchvo = str_replace('/', '\\', str_replace('../../..', '',$exArchivo));//-> lo ponemos en formato deseado
                $dirDestino = $_SERVER['DOCUMENT_ROOT'];
                $rutaArchivo = $dirDestino . $cadenaArchvo;
                unlink($rutaArchivo);//eliminamo y removemos
//-----------------------fin de la eliminacion


                $file = $entity->getImgTitulo();
//
//            //seteamos las variables de destino del doc, el nuevo nombre que tendra, y su ruta de acceso
                $dirDestino = $_SERVER['DOCUMENT_ROOT'] . "\\public\\img\\formacion\\";
                $nombreArchivo = $file->getClientOriginalName();
//
//            //efectuamos el movimiento
                $file->move($dirDestino, $nombreArchivo);
//            //obtenemos los binarios de nuestra imgen a traves de la ruta especificada
//
//            //metemos los binarios de data en la entidad
                $entity->setImgTitulo("../../../public/img/formacion/" . $nombreArchivo);


            }
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Edit success.'
            );

            return $this->redirect($this->generateUrl('alumnoformacionacademica_show', array('id' => $id,'curriculum'=>$cur )));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a FormacionAcademica entity.
     *
     * @Route("/{id}", name="alumnoformacionacademica_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:FormacionAcademica')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FormacionAcademica entity.');
            }

//----------------seteamos las variables de destino del doc, el nuevo nombre que tendra, y su ruta de acceso
            $cadenaArchvo = str_replace('/', '\\', str_replace('../../..', '', $entity->getImgTitulo()));//-> lo ponemos en formato deseado
            $dirDestino = $_SERVER['DOCUMENT_ROOT'];
            $rutaArchivo = $dirDestino . $cadenaArchvo;
            unlink($rutaArchivo);//eliminamo y removemos
//-----------------------fin de la eliminacion

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('alumnoformacionacademicaCurriculum',array('cur' => $id)));
    }

    /**
     * Creates a form to delete a FormacionAcademica entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('alumnoformacionacademica_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
