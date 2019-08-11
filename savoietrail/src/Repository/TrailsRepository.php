<?php

namespace App\Repository;

use App\Entity\Trails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query;

/**
 * @method Trails|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trails|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trails[]    findAll()
 * @method Trails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrailsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Trails::class);
    }

    public function findTrails() {
        $qb = $this->createQueryBuilder('u')
              ->getQuery();
  
        return $qb;
      }
  
      public function findTrailById(int $id) {
        $qb = $this->createQueryBuilder('u')
              ->andWhere('u.id = :id')
              ->setParameter('id', $id)
              ->getQuery()
              ->getOneOrNullResult();
  
        return $qb;
      }

    // /**
    //  * @return Trails[] Returns an array of Trails objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Trails
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
