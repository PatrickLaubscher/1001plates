<?php

namespace App\Repository;

use App\Entity\OpeningDays;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OpeningDays>
 */
class OpeningDaysRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OpeningDays::class);
    }

    public function findByRestaurantName(string $restaurantName): ?OpeningDays
    {
        return $this->createQueryBuilder('o')
            ->join('o.restaurant', 'r')
            ->where('r.name = :name')
            ->setParameter('name', $restaurantName)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByRestaurantId(string $id): ?OpeningDays
    {
        return $this->createQueryBuilder('o')
            ->join('o.restaurant', 'r')
            ->where('r.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    //    /**
    //     * @return OpeningDays[] Returns an array of OpeningDays objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?OpeningDays
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
