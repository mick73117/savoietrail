<?php

namespace App\Repository;

use App\Entity\PhotoAlbum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PhotoAlbum|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoAlbum|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoAlbum[]    findAll()
 * @method PhotoAlbum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoAlbumRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PhotoAlbum::class);
    }

    // /**
    //  * @return PhotoAlbum[] Returns an array of PhotoAlbum objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PhotoAlbum
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
