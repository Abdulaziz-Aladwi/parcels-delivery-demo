<?php

namespace App\Tests\Services;

use App\Constant\ParcelStatus;
use App\Constant\UserTypes;
use App\Entity\Parcel;
use App\Entity\User;
use App\Service\ParcelService;
use App\Service\StatisticService;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function PHPUnit\Framework\assertEquals;

class StatisticServiceTest extends KernelTestCase
{
    /** @var EntityManagerInterface  */
    private $entityManager;
    
    /** @var User  */
    private $sender;

    /** @var User  */
    private $biker;    

    /** @var Parcel  */
    private $pendingParcel;

    /** @var Parcel  */
    private $pickedUpParcel;    

    /** @var StatisticService  */
    private $statisticService;

    public function setup(): void
    {
        $this->entityManager = static::getContainer()->get('doctrine.orm.entity_manager');
        $this->statisticService = static::getContainer()->get('App\Service\StatisticService');
        
        $this->sender = $this->createSender();
        $this->biker = $this->createBiker();
        $this->pendingParcel = $this->createPendingParcel();
        $this->pickedUpParcel = $this->createPickedUpParcel();
    }

    public function test_should_return_correct__pending_parcel_count()
    {
        $criteria  = ['sender' => $this->sender, 'status' => ParcelStatus::TYPE_PENDING];
        $parcelsCount = $this->statisticService->getParcelsCount($criteria);
        assertEquals($parcelsCount, 1);
    }


    public function test_should_return_correct__picked_up_parcel_count()
    {
        $criteria  = ['sender' => $this->sender, 'status' => ParcelStatus::TYPE_PICKED_UP];
        $parcelsCount = $this->statisticService->getParcelsCount($criteria);
        assertEquals($parcelsCount, 1);
    }

    public function test_should_return_total_sender_parcels_count_regardless_status()
    {
        $criteria  = ['sender' => $this->sender];
        $parcelsCount = $this->statisticService->getParcelsCount($criteria);
        assertEquals($parcelsCount, 2);
    }    

    private function createPendingParcel(): Parcel
    {
        $parcel = new Parcel;
        $parcel->setName('testParcel');
        $parcel->setSender($this->sender);
        $parcel->setBiker($this->biker);
        $parcel->setPickUpAddress('pick up address');
        $parcel->setPickOffAddress('pick off address');
        $parcel->setStatus(ParcelStatus::TYPE_PENDING);
        $parcel->setCreatedAt(new \DateTime("now"));
        

        $this->entityManager->persist($parcel);
        $this->entityManager->flush();

        return $parcel;
    }

    private function createPickedUpParcel(): Parcel
    {
        $parcel = new Parcel;
        $parcel->setName('testParcel');
        $parcel->setSender($this->sender);
        $parcel->setBiker($this->biker);
        $parcel->setPickUpAddress('pick up address');
        $parcel->setPickOffAddress('pick off address');
        $parcel->setStatus(ParcelStatus::TYPE_PICKED_UP);
        $parcel->setCreatedAt(new \DateTime("now"));
        

        $this->entityManager->persist($parcel);
        $this->entityManager->flush();

        return $parcel;
    }    

    private function createSender(): User
    {
        $user = new User;
        $user->setFullName('sender');
        $user->setEmail('sneder@me.com');
        $user->setType(UserTypes::TYPE_SENDER);
        $user->setPassword('123456');
        $user->setRoles(["ROLE_SENDER"]);
        $user->setCreatedAt(new \DateTime("now"));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;

    }
    
    private function createBiker(): User
    {
        $user = new User;
        $user->setFullName('Biker');
        $user->setEmail('biker@me.com');
        $user->setType(UserTypes::TYPE_BIKER);
        $user->setPassword('123456');
        $user->setRoles(["ROLE_BIKER"]);
        $user->setCreatedAt(new \DateTime("now"));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;

    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown(): void
    {
        $this->truncateEntities();
    }
    
    private function truncateEntities()
    {
        $purger = new ORMPurger($this->entityManager);
        $purger->purge();
    }        
}
