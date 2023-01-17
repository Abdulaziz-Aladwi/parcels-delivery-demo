<?php

namespace App\DataFixtures;

use App\Constant\UserTypes;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SenderFixture extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
         $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setFullName(sprintf('Sender %s', $i + 1));
            $user->setEmail(sprintf('Sender_%s@me.com', $i + 1));
            $user->setPassword($this->passwordHasher->hashPassword($user, '102030'));
            $user->setType(UserTypes::TYPE_SENDER);
            $user->setRoles(['ROLE_SENDER']);
            $user->setCreatedAt();

            $manager->persist($user);
        }

        $manager->flush();
    }
}
