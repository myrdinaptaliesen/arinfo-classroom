<?php

namespace App\Repository;

use App\Entity\SubChapters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubChapters|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubChapters|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubChapters[]    findAll()
 * @method SubChapters[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubChaptersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubChapters::class);
    }

    // /**
    //  * @return SubChapters[] Returns an array of SubChapters objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SubChapters
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
