<?php

namespace App\Repository;

use App\Entity\ArticleReaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ArticleReaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleReaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleReaction[]    findAll()
 * @method ArticleReaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleReactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleReaction::class);
    }

    // /**
    //  * @return ArticleReaction[] Returns an array of ArticleReaction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ArticleReaction
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
