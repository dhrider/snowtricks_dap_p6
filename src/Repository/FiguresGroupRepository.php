<?php

namespace App\Repository;

use App\Entity\FiguresGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FiguresGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method FiguresGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method FiguresGroup[]    findAll()
 * @method FiguresGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FiguresGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FiguresGroup::class);
    }

    // /**
    //  * @return FiguresGroup[] Returns an array of FiguresGroup objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FiguresGroup
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
