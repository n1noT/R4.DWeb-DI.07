<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Lego;
use Symfony\Component\HttpFoundation\Response;

#[AsCommand(
    name: 'app:populate-database',
    description: 'Add a short description for your command',
)]
class PopulateDatabaseCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
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
        $data_json = file_get_contents('./src/Data/data.json');

        $data = json_decode($data_json, true);

        foreach ($data as $elt) {
          
            $l = new Lego($elt['id']);
            $l->setNom($elt['name']);
            $l->setDescription($elt['description']);
            $l->setPrice($elt['price']);
            $l->setPieces($elt['pieces']);
            $l->setBoxImage($elt['images']['box']);
            $l->setLegoImage($elt['images']['bg']);

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $this->entityManager->persist($l);

            // actually executes the queries (i.e. the INSERT query)
            $this->entityManager->flush();
        }
        
        // return new Response('Saved new product with id '.$l->getId());
        return Command::SUCCESS;

    }
}
