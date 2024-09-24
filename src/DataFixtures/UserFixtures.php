<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Admin
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'adminpassword'));
        $manager->persist($admin);

        // Manager
        $managerUser = new User();
        $managerUser->setEmail('manager@example.com');
        $managerUser->setRoles(['ROLE_MANAGER']);
        $managerUser->setPassword($this->passwordHasher->hashPassword($managerUser, 'managerpassword'));
        $manager->persist($managerUser);

        // Client
        $client = new User();
        $client->setEmail('client@example.com');
        $client->setRoles(['ROLE_USER']);
        $client->setPassword($this->passwordHasher->hashPassword($client, 'clientpassword'));
        $manager->persist($client);

        $manager->flush();
    }
}
