<?php

namespace App\Repository;

use App\Data\FilterData;
use App\Entity\Ideogramme;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Ideogramme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ideogramme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ideogramme[]    findAll()
 * @method Ideogramme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdeogrammeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Ideogramme::class);
    }
    
    /**
     * findSearch
     *
     * @param  FilterData $search
     * @return PaginationInterface
     */
    public function findSearch(FilterData $search): PaginationInterface
    {
        $query = $this->createQueryBuilder('i');

        if (!empty($search->signification)) {
            $query = $query
                ->andWhere('i.signification LIKE :q')
                ->setParameter('q', "%{$search->signification}%");
        }

        if (!empty($search->stroke)) {
            $query = $query
                ->andWhere('i.stroke = :stroke')
                ->setParameter('stroke', $search->stroke);
        }

        if (!empty($search->jlpt)) {
            $query = $query
                ->andWhere('i.jlpt = :jlpt')
                ->setParameter('jlpt', $search->jlpt);
        }

        return $this->paginator->paginate(
            $query,
            $search->page,
            9
        );
    }
}
