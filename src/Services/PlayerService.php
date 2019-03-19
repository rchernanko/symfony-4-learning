<?php

namespace App\Services;

use Psr\Log\LoggerInterface;

class PlayerService
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * PlayerService constructor.
     *
     * @param LoggerInterface $playersLogger
     */
    public function __construct(LoggerInterface $playersLogger)
    {
        $this->logger = $playersLogger;
    }

    /**
     * @param string $message
     */
    public function logSomeStuff(string $message)
    {
        $this->logger->info('This is a log with a specific message: ' . $message);
    }

}
