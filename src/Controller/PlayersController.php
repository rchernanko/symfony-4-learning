<?php

namespace App\Controller;

use App\Services\PlayerService;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PlayersController extends AbstractController
{
    /**
     * @Route("/players/{name}", name="app_players", methods={"GET"})
     *
     * @param $name
     * @param LoggerInterface $logger
     * @param PlayerService $playerService
     * @param string $testParameter
     *
     * @return Response
     */
    public function getPlayerAction($name, LoggerInterface $logger, PlayerService $playerService, string $testParameter)
    {
        //Checking that a 'bound' parameter (from within the services.yaml file) can be accessed in a controller action via autowiring
        $logger->info("test parameter is: " . $testParameter);

        //The line below will now get added to var/log/dev.log
        $logger->info('Someone is calling the getPlayerAction endpoint');

        //Now let's test the autowiring. Notice that I don't have to explicitly 'get' the PlayerService from the container
        //All I had to do was add its typehint as a function argument :-)
        $playerService->logSomeStuff('checking that the autowiring for player service works');

        return new Response(sprintf('Player requested is: %s', $name));

        //If we wanted to return a json response...

        //return new JsonResponse(['player' => 'Harry Kane']);
    }
}