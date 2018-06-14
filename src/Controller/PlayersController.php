<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class PlayersController
{
    /**
     * @Route("/players/{name}", name="app_players", methods={"GET"})
     *
     * @return Response
     */
    public function getPlayerAction($name)
    {
        return new Response(sprintf('Player requested is: %s', $name));

        //If we wanted to return a json response...

        //return new JsonResponse(['player' => 'Harry Kane']);
    }
}