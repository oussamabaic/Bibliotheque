<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    // /**
    //  * @return Livre[] Returns an array of Livre objects
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
    /**
     * Undocumented function
     *
     * @return Query
     */
    public function findAllBiblio(): Query
    {
        return $this->findBiblio()
            ->getQuery();
            
    }
  
    public function findBiblio(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql ='
                SELECT * FROM livre 
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function Categoryintelligenceartificielle(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql ='
                SELECT * FROM livre where categorys_id = 3
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function CategorySecurity(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql ='
            SELECT * FROM livre where categorys_id = 2
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function CategoryWeb(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql ='
            SELECT * FROM livre where categorys_id = 1
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function NewsLivres(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql ='
                SELECT * FROM livre  ORDER BY id DESC LIMIT 3
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    /*
    public function findOneBySomeField($value): ?Livre
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
