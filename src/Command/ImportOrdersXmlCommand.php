<?php

namespace App\Command;

use App\Services\OrderImporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import-orders-xml',
    description: 'Add a short description for your command',
)]
class ImportOrdersXmlCommand extends Command
{
    //use LockableTrait;

    private $orderImporter;

    public function __construct(OrderImporter $orderImporter)
    {
        parent::__construct();
        $this->orderImporter = $orderImporter;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $xmlFilePath = './public/data.xml';
        $this->orderImporter->importOrdersFromXml($xmlFilePath);

        $output->writeln('Orders imported successfully.');

        return Command::SUCCESS;
    }
}
