<?php

namespace App\Tests\Services;

use App\Constant\ParcelStatus;
use App\Constant\UserTypes;
use App\Entity\Parcel;
use App\Entity\User;
use App\Service\ParcelService;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;

class ParcelServiceTest extends KernelTestCase
{
    /** @var EntityManagerInterface  */
    private $entityManager;
    
    /** @var User  */
    private $sender;

    /** @var User  */
    private $biker;    

    /** @var Parcel  */
    private $parcel;

    /** @var ParcelService  */
    private $parcelService;

    public function setup(): void
    {
        $this->entityManager = static::getContainer()->get('doctrine.orm.entity_manager');
        $this->entityManager = static::getContainer()->get('doctrine.orm.entity_manager');
        $this->parcelService = static::getContainer()->get('App\Service\ParcelService');
        
        $this->sender = $this->createSender();
        $this->biker = $this->createBiker();
        $this->parcel = $this->createParcel();
    }

    public function test_should_return_query_builder()
    {
        $parcelsQueryBuilder = $this->parcelService->list([]);
        assertInstanceOf(QueryBuilder::class, $parcelsQueryBuilder);
    }

    public function test_should_return_sender_in_criteria_if_given_user_is_sender()
    {
        $criteria = $this->parcelService->buildParcelsCriteria($this->sender);
        assertArrayHasKey('sender', $criteria);
        assertEquals($criteria['sender']->getId(), $this->sender->getId());
    }

    public function test_should_through_exception_if_parcel_already_picked_up()
    {
        $this->expectExceptionMessage('Parcel Already Picked Up');
        $this->parcelService->validateParcelStatus($this->parcel);
    }

    public function test_should_confirm_biker_parcel_creation_form()
    {
        $bikerParcelForm = $this->parcelService->createBikerParcelForm($this->parcel);
        assertEquals($bikerParcelForm->getData()->getId(), $this->parcel->getId());
        assertEquals($bikerParcelForm->getData()->getBiker()->getId(), $this->biker->getId());  
    }

    public function test_should_confirm_sender_parcel_creation_form()
    {
        $bikerParcelForm = $this->parcelService->createSenderParcelForm($this->parcel);
        assertEquals($bikerParcelForm->getData()->getId(), $this->parcel->getId());
        assertEquals($bikerParcelForm->getData()->getSender()->getId(), $this->sender->getId());  
    }

    private function createParcel(): Parcel
    {
        $parcel = new Parcel;
        $parcel->setName('testParcel');
        $parcel->setSender($this->sender);
        $parcel->setBiker($this->biker);
        $parcel->setPickUpAddress('edasf');
        $parcel->setPickOffAddress('regfsdf');
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
