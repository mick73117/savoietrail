<?php

namespace App\Repository;

use App\Entity\TrailsComments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrailsComments|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrailsComments|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrailsComments[]    findAll()
 * @method TrailsComments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrailsCommentsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrailsComments::class);
    }

    // /**
    //  * @return TrailsComments[] Returns an array of TrailsComments objects
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
    public function findOneBySomeField($value): ?TrailsComments
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
