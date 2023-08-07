<?php

namespace App\Command;

use App\Services\OrderImporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use League\Csv\Reader;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\DependencyInjection\Attribute\Autowired;
use Symfony\Component\DependencyInjection\Attribute\Required;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Console\Command\Command;


#[AsCommand(
    name: 'app:import-orders-csv',
    description: 'Add a short description for your command',
)]
class ImportOrdersCsvCommand extends Command
{
    use LockableTrait;

    private $orderImporter;

    public function __construct(OrderImporter $orderImporter)
    {
        parent::__construct();
        $this->orderImporter = $orderImporter;
    }

    protected function configure()
    {
        $this->setDescription('Imports orders from a CSV file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $csvFilePath = './public/data.csv';
        $this->orderImporter->importOrdersFromCsv($csvFilePath);

        $output->writeln('Orders imported successfully.');

        return Command::SUCCESS;
    }
}
