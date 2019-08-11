<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query;


/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findUsers() {
        $qb = $this->createQueryBuilder('u')
              ->getQuery();
  
        return $qb;
      }
  
      public function findUserById(int $id) {
        $qb = $this->createQueryBuilder('u')
              ->andWhere('u.id = :id')
              ->setParameter('id', $id)
              ->getQuery()
              ->getOneOrNullResult();
  
        return $qb;
      }

      public function contains(User $user) {
        $qb = $this->createQueryBuilder('u')
        ->select('count(u.user)')
        ->where('u.user = :user')
        ->setParameter('user', $user);
  
        $result = $qb->getQuery()->getOneOrNullResult(Query::HYDRATE_SINGLE_SCALAR);
  
        return $result > 0;
      }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
