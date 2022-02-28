<?php

/**
 * Récupère les informations des idéogrammes
 */

namespace App\Handler;

use App\Entity\Ideogramme;
use App\Repository\IdeogrammeRepository;

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
}