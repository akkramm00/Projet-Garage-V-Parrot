<?php

namespace App\Repository;

use App\Entity\Arrivages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Arrivages>
 *
 * @method Arrivages|null find($id, $lockMode = null, $lockVersion = null)
 * @method Arrivages|null findOneBy(array $criteria, array $orderBy = null)
 * @method Arrivages[]    findAll()
 * @method Arrivages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArrivagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Arrivages::class);
    }

//    /**
//     * @return Arrivages[] Returns an array of Arrivages objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Arrivages
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
