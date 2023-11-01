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
    /**
     * This method allow us to find public Arrivages base on number of arrivages
     *
     * @param integer|null $nbArrivages
     * @return array
     */
    public function findPublicArrivages(?int $nbArrivages): array
    {
        $queryBuilder = $this->createQueryBuilder('a'); // Utilisez "createQueryBuilder" au lieu de "creatQueryBuilder"
        $queryBuilder->select('a')
            ->where('a.isPublic = 1')
            ->orderBy('a.createdAt', 'DESC');

        if (!$nbArrivages !== 0 || !$nbArrivages !== null) {
            $queryBuilder->setMaxResults($nbArrivages);
        }

        return $queryBuilder->getQuery()
            ->getResult();
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
