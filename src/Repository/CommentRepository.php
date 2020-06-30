<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }


    public function  findAllCommentsPaginate($id, $page, $nbMaxPerPage)
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->select('c')
            ->where('c.figure = :id')
            ->setParameter('id', $id)
            ->orderBy('c.createdAt', 'DESC')
        ;

        $query = $qb->getQuery();

        $firstResult = ($page - 1) * $nbMaxPerPage;
        $query->setFirstResult($firstResult)->setMaxResults($nbMaxPerPage);

        return new Paginator($query);
    }
}
