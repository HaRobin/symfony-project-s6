<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture
{

    public const CLIENT_REFERENCE = 'client';
    public function load(ObjectManager $manager): void
    {
        $clients = [
            [
                'email' => 'john.doe@example.com',
                'firstName' => 'John',
                'lastName' => 'Doe',
                'phoneNumber' => '1234567890',
                'address' => '123 Main St, Springfield, IL 62701',
            ],
            [
                'email' => 'jane.smith@example.com',
                'firstName' => 'Jane',
                'lastName' => 'Smith',
                'phoneNumber' => '1231231234',
                'address' => '456 Elm St, Springfield, IL 62701',
            ],
            [
                'email' => 'mike.jones@example.com',
                'firstName' => 'Mike',
                'lastName' => 'Jones',
                'phoneNumber' => '6543210987',
                'address' => '789 Oak St, Springfield, IL 62701',
            ]
        ];


        foreach ($clients as $key => $userData) {
            $client = new Client();

            // Set user data
            $client->setEmail($userData['email']);
            $client->setFirstName($userData['firstName']);
            $client->setLastName($userData['lastName']);
            $client->setPhoneNumber($userData['phoneNumber']);
            $client->setAddress($userData['address']);
            $client->setCreatedAt(new \DateTimeImmutable());
            $client->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($client);
            $this->addReference($this::CLIENT_REFERENCE . '_' . $key + 1, $client);
        }

        $manager->flush();
    }
}
