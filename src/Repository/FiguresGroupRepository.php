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


}
