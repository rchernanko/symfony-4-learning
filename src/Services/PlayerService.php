<?php

namespace App\Services;

use Psr\Log\LoggerInterface;

class PlayerService
{
    /**
     * @param string $message
     * @param LoggerInterface $logger
     */
    public function logSomeStuff(string $message)
    {
        echo $message;
    }

}