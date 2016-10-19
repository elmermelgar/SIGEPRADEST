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
     * @Route("/admin/info",name="verInfo")
     */
    public function verInfoAction(Request $request){
        // function Read-Mostrar
        $em=$this->getDoctrine()->getManager("default");

        //$info=$em->getRepository('AppBundle:InformacionAcademica')->findAll();
        $info=$em->getRepository('AppBundle:InformacionAcademica')->findBy( array(), array('fechaObtenido' => 'DESC')  );

        // validar usuario logueado
        if ($this->getUser()){
            return $this->render('AppBundle:Admin/InfoAcademica:index.html.twig', array('infos'=>$info));
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


        
        
        //Validar peticion POST
        if($request->isMethod("POST")) {

            //Recuperar valores encriptados
            // para el opcion
            //$fechaOb=$request->get("calendario_cl");
            //var_dump($fechaOb);
            //die();



            //Proceso de almacenamiento de datos en entidad Curso
            $infoNuevo=new InformacionAcademica();

            $infoNuevo->setIdSolicitud($em->getRepository("AppBundle:Solicitud")->find( $request->get("soli_fk") ));
            $infoNuevo->setInstitucion($request->get("instituto_txt"));
            $infoNuevo->setTitulo($request->get("titulo_txt"));
            $infoNuevo->setFechaObtenido(new \DateTime($request->get("calendario_cl")));
            
            
            //Persistir
            $em->persist($infoNuevo);

            //Guradar en la BD
            $em->flush();
            return $this->redirectToRoute('verInfo');
        }
        
        return $this->render("AppBundle:Admin/InfoAcademica:info_create.html.twig",
            array("sol"=>$solicitud,"usu" =>$usuario));
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
        
        if($request->isMethod("POST"))
        {


                //Almacenar la nueva info academica validada

                $datos->setIdSolicitud($em->getRepository("AppBundle:Solicitud")->find($request->get("soli_fk")));
                $datos->setInstitucion($request->get("instituto_txt"));
                $datos->setTitulo($request->get("titulo_txt"));
                $datos->setFechaObtenido(new \DateTime($request->get("calendario_cl")));

                // guardar cambios
                $em->flush();

                //$nombre = 'exito';
                //$mensaje= 'Usuario actualizado correctamente!';

                //$this->get('session')->getFlashBag()->add(
                //    ''.$nombre,
                //    ''.$mensaje
                //);



                //redireccionamiento


                $em2=$this->getDoctrine()->getManager("default");
                $info=$em2->getRepository('AppBundle:InformacionAcademica')->findAll();

                return $this->render('AppBundle:Admin/InfoAcademica:index.html.twig', array('infos'=>$info));
                //return $this->redirect($this->generateUrl('verInfo', array('info'=>$info)));
                //return $this->redirectToRoute('verInfo');
            
            
        }
        return $this->render('AppBundle:Admin/InfoAcademica:info_edit.html.twig', array(
            'info' => $datos ,'sol' => $solicitud, 'usu'=>$usuario
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
        }
        $em->remove($info);
        $em->flush();

        

        return $this->redirectToRoute("verInfo");
    }






}

