<?php

namespace App\Repository;

use App\Entity\ConfirmerCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ConfirmerCommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConfirmerCommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConfirmerCommande[]    findAll()
 * @method ConfirmerCommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfirmerCommandeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ConfirmerCommande::class);
    }

    // /**
    //  * @return ConfirmerCommande[] Returns an array of ConfirmerCommande objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ConfirmerCommande
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
