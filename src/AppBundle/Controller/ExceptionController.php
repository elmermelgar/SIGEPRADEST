<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Symfony\Component\HttpKernel\Exception\FlattenException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExceptionController extends Controller
{

    /**
     * ExceptionController constructor.
     */
    public function notFoundAction()
    {
        return $this->render('TwigBundle/views/Exception/error404.html.twig');
    }

    public function showAction(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null){
        return $this->render('@Twig/Exception/error404.html.twig');
    }



}
