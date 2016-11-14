<?php

namespace AppBundle\Controller\Secretaria;

use AppBundle\Controller\SecurityController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\InformacionAcademica;
use AppBundle\Entity\Usuario;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class InformacionAcademicaSecreController extends SecurityController{

    /**
     * @Route("/secretaria/informacion/{seleccion}", name="verInfoSecre", defaults={"seleccion" = 0} )
     */
    public function verInfoSecreAction(Request $request,$seleccion){
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

                return $this->render('AppBundle:Secretaria/InfoAcademica:index.html.twig', array(
                    'infos'=>$info, 'usu'=>$usu,'sol'=>$solicitud,'result'=>$result, 'seleccion'=>$seleccion));
            } else{
                return $this->redirectToRoute('login');
            }

        }catch (\Exception $e){
            return $this->redirectToRoute('verInfoSecre');
        }

    }


    /**
     * @Route("/secretaria/info_create",name="createInfoSecre")
     */
    public function createInfoAction(Request $request)
    {

        try{
            // validar usuario logueado
            if ($this->getUser()){

                $em=$this->getDoctrine()->getManager("default");

                $solicitud=$em->getRepository("AppBundle:Solicitud")->findAll();
                $usuario=$em->getRepository("AppBundle:Usuario")->findAll();

                $info=$em->getRepository('AppBundle:InformacionAcademica')->findAll();

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
                    $infoNuevo->setAnio($request->get("calendario_cl"));

                    $valor = $infoNuevo->getIdSolicitud()->getIdUi()->getIdUi();

                    //Persistir
                    $em->persist($infoNuevo);
                    $this->MensajeFlash('exito','Informacion creada correctamente!');

                    //Guradar en la BD
                    $em->flush();
                    return $this->redirectToRoute('verInfoSecre',array('seleccion'=>$valor));
                }

                return $this->render("AppBundle:Secretaria/InfoAcademica:info_create.html.twig",
                    array('infos'=>$info, 'usu' =>$usuario, 'sol'=>$solicitud, 'result'=>$result));
            } else{
                //throw $this->createNotFoundException("no se encontro pagina",null);
                $this->MensajeFlash('Error','No se puede mostrar la pagina, no esta logueado!');
                return $this->redirectToRoute('login');
            }
        }catch (\Exception $e){
            return $this->redirectToRoute('verInfoSecre');
        }
    }


    /**
     * @Route("/secretaria/informacion/{id}/edit", name="editinfoSecre" , defaults={"id" = 0})
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
                    $datos->setAnio($request->get("calendario_cl"));

                    // guardar cambios
                    $em->flush();

                    //redireccionamiento
                    $this->MensajeFlash('exito','Informacion actualizada correctamente!');
                    $em2=$this->getDoctrine()->getManager("default");
                    $info=$em2->getRepository('AppBundle:InformacionAcademica')->findAll();
                    $valor = $datos->getIdSolicitud()->getIdUi()->getIdUi();


                    return $this->redirectToRoute('verInfoSecre',array('seleccion'=>$valor));
                }
                return $this->render('AppBundle:Secretaria/InfoAcademica:info_edit.html.twig', array(
                    'info' => $datos ,'sol' => $solicitud, 'usu'=>$usuario, 'result'=>$result));
            } else{

                $this->MensajeFlash('Error','No se puede mostrar la pagina, no esta logueado!');
                return $this->redirectToRoute('login');
            }
        }catch (\Exception $e){

            return $this->redirectToRoute('verInfoSecre');
        }

    }

    /**
     * @Route("/secretaria/informacion/delete/{id}", name="deleteInfoSecre" , defaults={"id" = 0})
     */
    public function deleteInformacionAction($id, Request $request)
    {

        try {
            // validar usuario logueado
            if ($this->getUser()) {

                $em = $this->getDoctrine()->getManager();
                $info = $em->getRepository('AppBundle:InformacionAcademica')->find($id);

                if (!$info) {
                    throw $this->createNotFoundException('No existe el informacion con la ID' . $id);
                } else {
                    $em->remove($info);
                    $flush = $em->flush();

                    $valor = $info->getIdSolicitud()->getIdUi()->getIdUi();

                    if ($flush == null) {
                        $this->MensajeFlash('exito', 'Informacion eliminada correctamente!');
                    } else {
                        $this->MensajeFlash('Error', 'No se puede eliminar!');
                    }
                }
                return $this->redirectToRoute("verInfoSecre", array('seleccion' => $valor));
            } else {
                //throw $this->createNotFoundException("no se encontro pagina",null);
                $this->MensajeFlash('Error', 'No se puede mostrar la pagina, no esta logueado!');
                return $this->redirectToRoute('login');
            }
        } catch (\Exception $e) {
            return $this->redirectToRoute('verInfoSecre');
        }
    }
} // fin de Informacion Controller



