<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TwigDemoController extends AbstractController
{
    //Whenever we want to render a template in a controller, we must extend from Abstract Controller as it has some
    //highly useful functions (e.g. render())

    /**
     * @Route("/twig/demo")
     *
     * @return Response
     */
    public function getTwigDemoAction()
    {
        dump($this);

        return $this->render('base.html.twig');
    }

}