<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Controller\SecurityController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\InformacionAcademica;
use AppBundle\Entity\Usuario;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class InformacionAcademicaController extends SecurityController{

    /**
     * @Route("/admin/informacion/{seleccion}", name="verInfo", defaults={"seleccion" = 0} )
     * @Route("/secretaria/informacion/{seleccion}", name="verInfo2", defaults={"seleccion" = 0} )
     * @Security("has_role('ROLE_administrador') or has_role('ROLE_secretaria') ")
     */
    public function verInfoAction(Request $request,$seleccion){
        // function Read-Mostrar

        try{
            // validar usuario logueado
            if ($this->getUser()){
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

                return $this->render('AppBundle:Admin/InfoAcademica:index.html.twig', array(
                       'infos'=>$info, 'usu'=>$usu,'sol'=>$solicitud,'result'=>$result, 'seleccion'=>$seleccion));
            } else{
                //throw $this->createNotFoundException("no se encontro pagina",null);
                $this->MensajeFlash('Error','No se puede mostrar la pagina, no esta logueado!');
                return $this->redirectToRoute('login');
            }

        }catch (\Exception $e){
            //echo $e -> getMessage();
            //throw $this->createNotFoundException("no se encontro pagina" ,null);
            //$this->MensajeFlash('Error','No se puede mostrar la pagina, entrada de dato invalido!');
            return $this->redirectToRoute('verInfo');
        }

    }


    /**
     * @Route("/admin/info_create",name="createInfo")
     * @Security("has_role('ROLE_administrador') or has_role('ROLE_secretaria') ")
     */
    public function createInfoAction(Request $request)
    {

        try{
            // validar usuario logueado
            if ($this->getUser()){

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
                $this->MensajeFlash('exito','Informacion creada correctamente!');

                //Guradar en la BD
                $em->flush();
                return $this->redirectToRoute('verInfo',array('seleccion'=>$valor));
                }

                return $this->render("AppBundle:Admin/InfoAcademica:info_create.html.twig",
                    array('infos'=>$info, 'usu' =>$usuario, 'sol'=>$solicitud, 'result'=>$result));
                } else{
                    //throw $this->createNotFoundException("no se encontro pagina",null);
                    $this->MensajeFlash('Error','No se puede mostrar la pagina, no esta logueado!');
                    return $this->redirectToRoute('login');
                }
        }catch (\Exception $e){
            echo $e -> getMessage();
            //throw $this->createNotFoundException("no se encontro pagina" ,null);
            //$this->MensajeFlash('Error','No se puede mostrar la pagina, entrada de dato invalido!');
            return $this->redirectToRoute('verInfo');
        }
    }


    /**
     * @Route("/admin/informacion/{id}/edit", name="editInfo" , defaults={"id" = 0})
     * @Security("has_role('ROLE_administrador') or has_role('ROLE_secretaria') ")
     */

    public function editarUsuarioAction($id, Request $request)
    {
       try{
            // validar usuario logueado
            if ($this->getUser()){
                $em=$this->getDoctrine()->getManager("default");

                //Seleccionando un solo usuario";
                $datos=$this->getDoctrine()->getRepository('AppBundle:InformacionAcademica')->find($id);

                $solicitud=$em->getRepository("AppBundle:Solicitud")->findAll();
                $usuario=$em->getRepository("AppBundle:Usuario")->findAll();

                $sql = "SELECT DISTINCT u.nombre , u.id_ui, u.nombre || ' ' || u.apellido as completo FROM usuario u , solicitud s WHERE  s.id_ui = u.id_ui Order BY completo DESC";
                $stmt = $em->getConnection()->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll();



                if($request->isMethod("POST")){
                    //Almacenar la nueva info academica validada
                    $datos->setIdSolicitud($em->getRepository("AppBundle:Solicitud")->find($request->get("select2")));
                    $datos->setInstitucion($request->get("instituto_txt"));
                    $datos->setTitulo($request->get("titulo_txt"));
                    $datos->setFechaObtenido(new \DateTime($request->get("calendario_cl")));

                    // guardar cambios
                    $em->flush();
            
                    //redireccionamiento
                    $this->MensajeFlash('exito','Informacion actualizada correctamente!');
                    $em2=$this->getDoctrine()->getManager("default");
                    $info=$em2->getRepository('AppBundle:InformacionAcademica')->findAll();
                    $valor = $datos->getIdSolicitud()->getIdUi()->getIdUi();

                    //return $this->render('AppBundle:Admin/InfoAcademica:index.html.twig', array('infos'=>$info));
                    //return $this->redirect($this->generateUrl('verInfo', array('info'=>$info)));
                    return $this->redirectToRoute('verInfo',array('seleccion'=>$valor));
                }
                    return $this->render('AppBundle:Admin/InfoAcademica:info_edit.html.twig', array(
                    'info' => $datos ,'sol' => $solicitud, 'usu'=>$usuario, 'result'=>$result));
            } else{
                //throw $this->createNotFoundException("no se encontro pagina",null);
                $this->MensajeFlash('Error','No se puede mostrar la pagina, no esta logueado!');
                return $this->redirectToRoute('login');
            }
       }catch (\Exception $e){
           echo $e -> getMessage();
           //throw $this->createNotFoundException("no se encontro pagina" ,null);
           //$this->MensajeFlash('Error','No se puede mostrar la pagina, entrada de dato invalido!');
           return $this->redirectToRoute('verInfo');
       }

    }

    /**
     * @Route("/informacion/delete/{id}", name="deleteInfo" , defaults={"id" = 0})
     * @Security("has_role('ROLE_administrador') or has_role('ROLE_secretaria') ")
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


            //var_dump( ($flush == null) );
            //die();

            if ($flush == null){
                $this->MensajeFlash('exito','Informacion eliminada correctamente!');
            }else{
                $this->MensajeFlash('Error','No se puede eliminar!');
            }
        }



        return $this->redirectToRoute("verInfo",array('seleccion'=>$valor));
    }



}