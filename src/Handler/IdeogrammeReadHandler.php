<?php

/**
 * Récupère les informations des idéogrammes
 */

namespace App\Handler;

use App\Data\FilterData;
use App\Entity\Ideogramme;
use App\Repository\IdeogrammeRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;

class IdeogrammeReadHandler
{
    public function __construct(private IdeogrammeRepository $repository)
    {}
    
    /**
     * getLastKanji
     * Les derniers kanji enregistrés
     *
     * @param  int $number
     * @return array<Ideogramme>
     */
    public function getLastKanji(int $number): array
    {
        return $this->repository->findBy([], [], $number);
    }
    
    /**
     * getAll
     *
     * @return array<Ideogramme>
     */
    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function getSearch(FilterData $data): PaginationInterface
    {
        return $this->repository->findSearch($data);
    }
}