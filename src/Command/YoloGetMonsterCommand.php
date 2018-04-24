<?php

namespace App\Command;

use App\Controller\MonsterController;
use App\Repository\MonsterRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class YoloGetMonsterCommand extends Command
{
    protected static $defaultName = 'yolo';
    /**
     * @var MonsterRepository
     */
    private $monsterRepository;

    /**
     * YoloGetMonsterCommand constructor.
     * @param MonsterRepository $monsterRepository
     */
    public function __construct(MonsterRepository $monsterRepository)
    {
        parent::__construct();
        $this->monsterRepository = $monsterRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Getting the monsters')

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $io = new SymfonyStyle($input, $output);
//        $arg1 = $input->getArgument('arg1');

        $lesgrosmonstres = $this->monsterRepository->findAll();
        foreach ($lesgrosmonstres as $monster){
            $output->writeln("<info>".$monster->getName()."</info><comment>".$monster->getType()."</comment>");
        }





    }
}
