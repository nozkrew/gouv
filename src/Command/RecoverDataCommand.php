<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RecoverDataCommand extends Command
{
    protected static $defaultName = 'app:recover-data';

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('depCode', InputArgument::OPTIONAL, 'Code du département')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $depCode = $input->getArgument('depCode');

        //recupère les cities ou le departement_code est celui passé
        //boucle sur les cities 
        //  Recupère l'url pour chaque cité => curl
        //  Enregistre les prix
        
        if ($depCode) {
            $io->note(sprintf('You passed an argument: %s', $depCode));
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}
