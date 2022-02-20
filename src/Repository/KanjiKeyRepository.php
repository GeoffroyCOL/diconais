<?php

namespace App\Repository;

use App\Entity\KanjiKey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KanjiKey|null find($id, $lockMode = null, $lockVersion = null)
 * @method KanjiKey|null findOneBy(array $criteria, array $orderBy = null)
 * @method KanjiKey[]    findAll()
 * @method KanjiKey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KanjiKeyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KanjiKey::class);
    }

    // /**
    //  * @return KanjiKey[] Returns an array of KanjiKey objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?KanjiKey
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
