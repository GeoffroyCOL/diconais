<?php

/**
 * Fournit un liste de mot pour les fixtures.
 */

namespace App\DataFixtures\Faker\Provider;

use App\Entity\Example;
use App\Entity\Ideogramme;

class ExampleProvider
{
    public static function exampleProvider(Ideogramme $ideogramme): array
    {
        $example1 = new Example;
        $example2 = new Example;

        $example1
            ->setIdeogramme($ideogramme)
            ->setList("liste 1")
        ;

        $example2
            ->setIdeogramme($ideogramme)
            ->setList("liste 2")
        ;

        return [$example1, $example2];
    }
}
