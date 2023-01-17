<?php

namespace App\Repository;

use App\Entity\Parcel;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

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
    
    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Parcel::class);
        $this->user = $security->getUser();
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

    public function get(): QueryBuilder
    {
        return $this->createQueryBuilder('parcel')
            ->andWhere('parcel.sender = :val')
            ->setParameter('val', $this->user)
            ->leftJoin('parcel.biker', 'biker')
            ->orderBy('parcel.createdAt', 'desc');
    }

    public function getParcelsCount($criteria): int
    {
        $queryBuilder = $this->createQueryBuilder('parcel')->select('count(parcel.id)');
        $queryBuilder->andWhere('parcel.sender = :val')->setParameter('val', $this->user);

        if ($criteria['status']) {
            $queryBuilder->andWhere('parcel.status = :status')
                ->setParameter('status', $criteria['status']);
        }
        
        return $queryBuilder->getQuery()->getSingleScalarResult();
    }
}
