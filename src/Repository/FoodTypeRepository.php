<?php

namespace App\Repository;

use App\Entity\FoodType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FoodType>
 */
class FoodTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FoodType::class);
    }


    public function FindAllByCity(string $cityName): array
    {
        return $this->createQueryBuilder('f')
            ->join('f.restaurants', 'r')
            ->join('r.city', 'c')
            ->where('c.name = :cityName')
            ->setParameter('cityName', $cityName)
            ->getQuery()
            ->getResult();

    }

    //    /**
    //     * @return FoodType[] Returns an array of FoodType objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?FoodType
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
