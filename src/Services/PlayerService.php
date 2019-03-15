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
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param string $message
     */
    public function logSomeStuff(string $message)
    {
        $this->logger->info('This is a log with a specific message: ' . $message);
    }

}
