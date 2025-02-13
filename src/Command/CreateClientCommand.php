<?php

namespace App\Command;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:client:create',
    description: 'Ajoute un nouveau client via la ligne de commande.'
)]
class CreateClientCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $firstname = $io->ask('Entrez le prénom du client: ', null, function (string $value) {
            if (empty($value)) {
                throw new \RuntimeException('Le prénom ne peut pas être vide.');
            }

            if (preg_match('/[^a-zA-Z]/', $value)) {
                throw new \RuntimeException('Le prénom ne peut contenir que des lettres.');
            }

            return $value;
        });
        $lastname = $io->ask('Entrez le nom du client: ', null, function (string $value) {
            if (empty($value)) {
                throw new \RuntimeException('Le prénom ne peut pas être vide.');
            }

            if (preg_match('/[^a-zA-Z]/', $value)) {
                throw new \RuntimeException('Le prénom ne peut contenir que des lettres.');
            }

            return $value;
        });
        $email = $io->ask('Entrez l\'email du client: ', null, function (string $value) {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                throw new \RuntimeException('L\'email n\'est pas valide.');
            }

            return $value;
        });
        $phoneNumber = $io->ask('Entrez le numéro de téléphone du client: ', null, function (string $value) {
            if (!preg_match('/^[0-9]{10}$/', $value)) {
                throw new \RuntimeException('Le numéro de téléphone n\'est pas valide.');
            }

            return $value;
        });
        $address = $io->ask('Entrez l\'adresse du client: ');

        $client = new Client();
        $client->setFirstname($firstname);
        $client->setLastname($lastname);
        $client->setEmail($email);
        $client->setPhoneNumber($phoneNumber);
        $client->setAddress($address);
        $client->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        $output->writeln('Client ajouté avec succès !');

        return Command::SUCCESS;
    }
}
