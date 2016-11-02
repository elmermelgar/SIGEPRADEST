<?php

namespace AppBundle\Controller\Admin;

use AppBundle\AppBundle;
use AppBundle\Controller\DefaultController;
use AppBundle\Controller\SecurityController;

use AppBundle\Entity\InformacionAcademica;
use AppBundle\Entity\Solicitud;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


use Symfony\Component\Validator\Constraints\Date;


class InformacionAcademicaController extends DefaultController{

    /**
     * @Route("/admin/info/{seleccion}",name="verInfo", defaults={"seleccion" = 0})
     */
    public function verInfoAction(Request $request,$seleccion){
        // function Read-Mostrar
        $em=$this->getDoctrine()->getManager("default");



        $usu =$em->getRepository('AppBundle:Usuario')->findAll();
        $seleccion = $em->getRepository('AppBundle:Usuario')->find($seleccion);
        $solicitud=$em->getRepository("AppBundle:Solicitud")->findAll();


        //$info=$em->getRepository('AppBundle:InformacionAcademica')->findAll();
        $info=$em->getRepository('AppBundle:InformacionAcademica')->findBy( array(), array('idSolicitud' => 'ASC')  );

        $sql = "SELECT DISTINCT u.nombre , u.id_ui, u.nombre || ' ' || u.apellido as completo FROM usuario u , solicitud s WHERE  s.id_ui = u.id_ui Order BY completo DESC";
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        // validar usuario logueado
        if ($this->getUser()){
            return $this->render('AppBundle:Admin/InfoAcademica:index.html.twig', array(
                'infos'=>$info, 'usu'=>$usu,'sol'=>$solicitud,'result'=>$result, 'seleccion'=>$seleccion));
        } else
            return $this->redirectToRoute('login');
    }


    /**
     * @Route("/admin/info_create",name="createInfo")
     */
    public function createInfoAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager("default");

        $solicitud=$em->getRepository("AppBundle:Solicitud")->findAll();
        $usuario=$em->getRepository("AppBundle:Usuario")->findAll();
        $info=$em->getRepository('AppBundle:InformacionAcademica')->findBy( array(), array('fechaObtenido' => 'DESC')  );


        $sql = "SELECT DISTINCT u.nombre , u.id_ui, u.nombre || ' ' || u.apellido as completo FROM usuario u , solicitud s WHERE  s.id_ui = u.id_ui Order BY completo DESC";
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        //Validar peticion POST
        if($request->isMethod("POST")) {

            //Proceso de almacenamiento de datos en entidad informacion academica
            $infoNuevo=new InformacionAcademica();
            $infoNuevo->setIdSolicitud($em->getRepository("AppBundle:Solicitud")->find( $request->get("select2") ));
            $infoNuevo->setInstitucion($request->get("instituto_txt"));
            $infoNuevo->setTitulo($request->get("titulo_txt"));
            $infoNuevo->setFechaObtenido(new \DateTime($request->get("calendario_cl")));

            $valor = $infoNuevo->getIdSolicitud()->getIdUi()->getIdUi();

            //Persistir
            $em->persist($infoNuevo);

            //Guradar en la BD
            $em->flush();
            return $this->redirectToRoute('verInfo',array('seleccion'=>$valor));
        }

        return $this->render("AppBundle:Admin/InfoAcademica:info_create.html.twig",
            array('infos'=>$info, 'usu' =>$usuario, 'sol'=>$solicitud, 'result'=>$result));
    }


    /**
     * @Route("/admin/informacion/{id}/edit", name="editInfo")
     */

    public function editarUsuarioAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager("default");

        //Seleccionando un solo usuario";
        $datos=$this->getDoctrine()->getRepository('AppBundle:InformacionAcademica')->find($id);

        $solicitud=$em->getRepository("AppBundle:Solicitud")->findAll();
        $usuario=$em->getRepository("AppBundle:Usuario")->findAll();

        $sql = "SELECT DISTINCT u.nombre , u.id_ui, u.nombre || ' ' || u.apellido as completo FROM usuario u , solicitud s WHERE  s.id_ui = u.id_ui Order BY completo DESC";
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();



        if($request->isMethod("POST"))
        {
            //Almacenar la nueva info academica validada

            $datos->setIdSolicitud($em->getRepository("AppBundle:Solicitud")->find($request->get("select2")));
            $datos->setInstitucion($request->get("instituto_txt"));
            $datos->setTitulo($request->get("titulo_txt"));
            $datos->setFechaObtenido(new \DateTime($request->get("calendario_cl")));

            // guardar cambios
            $em->flush();
            
            //redireccionamiento
            $em2=$this->getDoctrine()->getManager("default");
            $info=$em2->getRepository('AppBundle:InformacionAcademica')->findAll();
            $valor = $datos->getIdSolicitud()->getIdUi()->getIdUi();


            //return $this->render('AppBundle:Admin/InfoAcademica:index.html.twig', array('infos'=>$info));
            //return $this->redirect($this->generateUrl('verInfo', array('info'=>$info)));
            return $this->redirectToRoute('verInfo',array('seleccion'=>$valor));
        }
        return $this->render('AppBundle:Admin/InfoAcademica:info_edit.html.twig', array(
            'info' => $datos ,'sol' => $solicitud, 'usu'=>$usuario, 'result'=>$result
        ));
    }

    /**
     * @Route("/admin/informacion/delete/{id}", name="deleteInfo")
     */
    public function deleteInformacionAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $info=$em->getRepository('AppBundle:InformacionAcademica')->find($id);

        if(!$info){
            throw $this->createNotFoundException('No existe el informacion con la ID'.$id);
        } else {
            $em->remove($info);
            $flush = $em->flush();

            $valor=$info->getIdSolicitud()->getIdUi()->getIdUi();

            if ($flush = null){
                echo "Borrado correctamente";
            }else{
                echo "el post no se ha borrado";
            }
        }



        return $this->redirectToRoute("verInfo",array('seleccion'=>$valor));
    }



}