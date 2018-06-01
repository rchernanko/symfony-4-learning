<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class PlayersController
{
    /**
     * @Route("/players/{name}")
     *
     * @return Response
     */
    public function getPlayerAction($name)
    {
        return new Response(sprintf('Player requested is: %s', $name));
    }
}