<?php

namespace App\Repository;

use App\Entity\Parcel;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Parcel>
 *
 * @method Parcel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parcel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parcel[]    findAll()
 * @method Parcel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParcelRepository extends ServiceEntityRepository
{
    /** @var User */
    private $user;
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parcel::class);
    }

    public function add(Parcel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Parcel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function get(array $criteria = []): QueryBuilder
    {
        $queryBuilder =  $this->createQueryBuilder('parcel');

        if ( isset($criteria['sender']) ) {
            $queryBuilder->andWhere('parcel.sender = :sender')->setParameter('sender', $criteria['sender']);
        }

        if ( isset($criteria['biker']) ) {
            $queryBuilder->andWhere('parcel.biker = :biker')->setParameter('biker', $criteria['biker']);
        }     

        if ( isset($criteria['status']) ) {
            $queryBuilder->andWhere('parcel.status = :status')->setParameter('status', $criteria['status']);
        }     

           return $queryBuilder->leftJoin('parcel.biker', 'biker')
                ->orderBy('parcel.createdAt', 'desc');
    }

    public function getParcelsCount($criteria): int
    {
        $queryBuilder = $this->createQueryBuilder('parcel')->select('count(parcel.id)');

        if ( isset($criteria['sender']) ) {
            $queryBuilder->andWhere('parcel.sender = :sender')->setParameter('sender', $criteria['sender']);
        }

        if ( isset($criteria['biker']) ) {
            $queryBuilder->andWhere('parcel.biker = :biker')->setParameter('biker', $criteria['biker']);
        }        

        if ( isset($criteria['status']) ) {
            $queryBuilder->andWhere('parcel.status = :status')->setParameter('status', $criteria['status']);
        }
        
        return $queryBuilder->getQuery()->getSingleScalarResult();
    }
}
