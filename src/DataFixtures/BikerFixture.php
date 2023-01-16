<?php

namespace App\DataFixtures;

use App\Constant\UserTypes;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class BikerFixture extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
         $this->passwordHasher = $passwordHasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFullName(sprintf('Biker %s', $i + 1));
            $user->setEmail(sprintf('Biker_%s@me.com', $i + 1));
            $user->setPassword($this->passwordHasher->hashPassword($user, '102030'));
            $user->setType(UserTypes::TYPE_BIKER);
            $user->setRoles(['ROLE_BIKER']);
            $user->setCreatedAt();

            $manager->persist($user);
        }

        $manager->flush();
    }
}
