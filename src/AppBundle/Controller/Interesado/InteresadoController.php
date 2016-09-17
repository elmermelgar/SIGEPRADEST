<?php

namespace AppBundle\Controller\Interesado;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InteresadoController extends Controller
{
    /**
     * @Route("/interesado/register", name="register")
     */
    public function registerAction(){
        return $this->render('AppBundle:Interesado:registro.html.twig');
    }


}
