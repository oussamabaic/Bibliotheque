<?php

namespace App\Repository;

use App\Entity\LivreLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LivreLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method LivreLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method LivreLike[]    findAll()
 * @method LivreLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreLikeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LivreLike::class);
    }

    // /**
    //  * @return LivreLike[] Returns an array of LivreLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LivreLike
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
