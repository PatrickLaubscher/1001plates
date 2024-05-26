<?php

namespace App\Repository;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Restaurant>
 */
class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Restaurant::class);
    }


    public function paginateRestaurant(int $page, int $itemPerPage): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->createQueryBuilder('r'),
            $page,
            $itemPerPage,
            [
                'distinct' => false,
                'sortFieldAllowList' => ['r.title', 'r.date']
            ]
        );
    }

    /**
     * 
     * 
     */
    public function paginateRestaurantByCity(int $page, int $itemPerPage, string $cityName): PaginationInterface
    {
        return $this->paginator->paginate(
            $this
                ->createQueryBuilder('r')
                ->join('r.city', 'c')
                ->andWhere('c.name = :cityName')
                ->setParameter('cityName', $cityName),
            $page,
            $itemPerPage,
            [
                'distinct' => false,
                'sortFieldAllowList' => ['r.title', 'r.date']
            ]
        );
    }


    public function findRestaurantByName(string $name): ?array
    {
        return $this->createQueryBuilder('r')
            ->where('r.name like :name')
            ->setParameter('name', '%' . $name . '%')
            ->getQuery()
            ->getResult();
    }

    public function findAllRestaurantByCityAndFoodType(string $cityName, string $foodTypeName): ?array
    {
        return $this->createQueryBuilder('r')
            ->join('r.city', 'c')
            ->join('r.foodType', 'f')
            ->where('c.name = :cityName')
            ->andwhere('f.name = :foodTypeName')
            ->setParameter('cityName', $cityName)
            ->setParameter('foodTypeName', $foodTypeName)
            ->getQuery()
            ->getResult();
    }


//    /**
//     * @return Restaurant[] Returns an array of Restaurant objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Restaurant
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
