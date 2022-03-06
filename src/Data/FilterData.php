<?php

namespace App\Data;

/**
 * FilterData
 * Représente les données liées à un filtre sur les idéogrammes
 */
class FilterData
{
    public ?string $signification;

    public ?int $stroke;

    public ?int $jlpt;

    public int $page = 1;
}