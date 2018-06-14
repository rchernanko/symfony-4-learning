<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class PlayersController
{
    /**
     * @Route("/players/{name}", name="app_players", methods={"GET"})
     *
     * @return Response
     */
    public function getPlayerAction($name, LoggerInterface $logger)
    {
        //The line below will now get added to var/log/dev.log
        $logger->info('Someone is calling the getPlayerAction endpoint');

        return new Response(sprintf('Player requested is: %s', $name));

        //If we wanted to return a json response...

        //return new JsonResponse(['player' => 'Harry Kane']);
    }
}