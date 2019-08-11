<?php

namespace App\Repository;

use App\Entity\TrailsUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrailsUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrailsUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrailsUser[]    findAll()
 * @method TrailsUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrailsUserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrailsUser::class);
    }

    // /**
    //  * @return TrailsUser[] Returns an array of TrailsUser objects
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
    public function findOneBySomeField($value): ?TrailsUser
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
