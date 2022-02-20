<?php

namespace App\Repository;

use App\Entity\Ideogramme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ideogramme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ideogramme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ideogramme[]    findAll()
 * @method Ideogramme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdeogrammeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ideogramme::class);
    }

    // /**
    //  * @return Ideogramme[] Returns an array of Ideogramme objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ideogramme
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
