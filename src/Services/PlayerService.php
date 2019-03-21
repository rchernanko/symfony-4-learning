<?php

namespace App\Services;

use Psr\Log\LoggerInterface;

class PlayerService
{
    /** @var LoggerInterface */
    private $logger;
    /** @var string */
    private $testParameter;

    /**
     * PlayerService constructor.
     *
     * @param LoggerInterface $playersLogger
     * @param string $testParameter
     */
    public function __construct(LoggerInterface $playersLogger, string $testParameter)
    {
        $this->logger = $playersLogger;
        $this->testParameter = $testParameter;

        $this->logger->info('Logging the test parameter: '. $this->testParameter);
    }

    /**
     * @param string $message
     */
    public function logSomeStuff(string $message)
    {
        $this->logger->info('This is a log with a specific message: ' . $message);
    }

}
