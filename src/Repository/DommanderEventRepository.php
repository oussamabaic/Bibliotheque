<?php

namespace App\Repository;

use App\Entity\DommanderEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DommanderEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method DommanderEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method DommanderEvent[]    findAll()
 * @method DommanderEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DommanderEventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DommanderEvent::class);
    }

    // /**
    //  * @return DommanderEvent[] Returns an array of DommanderEvent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DommanderEvent
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
