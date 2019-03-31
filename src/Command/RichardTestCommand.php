<?php

namespace App\Command;

use App\Services\PlayerService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RichardTestCommand extends Command
{
    /**
     * @var PlayerService
     */
    private $playerService;

    /**
     * RichardTestCommand constructor.
     *
     * @param PlayerService $playerService
     * @param string|null $name
     */
    public function __construct(PlayerService $playerService, ?string $name = null)
    {
        parent::__construct($name);
        $this->playerService = $playerService;
    }

    protected static $defaultName = 'richard:test-command';

    protected function configure()
    {
        $this
            ->setDescription('My test command')
            ->addArgument('number', InputArgument::REQUIRED, 'A number')
            ->addOption('format', null, InputOption::VALUE_REQUIRED, 'The output format', 'text')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $number = $input->getArgument('number');

        $data = [
            'number' => $number
        ];

        switch ($input->getOption('format')) {
            case 'text':

                $players = [
                    'harry kane' => 'tottenham hotspurs',
                    'eden hazard' => 'chelsea',
                    'aaron ramsey' => 'juventus'
                ];

                $rows = [];
                foreach ($players as $key => $val) {
                    $rows[] = [$key, $val];
                }

                $io->table(['Player', 'Team'], $rows);
                $this->playerService->logSomeStuff('COMMAND LOVE');

                //$io->listing($data); Use this to simply print a list of items in an array (see readme)

                break;
            case 'json':
                $io->write(json_encode($data));
                break;
            default:
                throw new \Exception('what kind of a crazy format is that!?');
        }
    }
}
