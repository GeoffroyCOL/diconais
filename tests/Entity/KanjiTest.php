<?php

namespace App\Tests\Entity;

use App\Entity\Kanji;
use App\Entity\Ideogramme;

class KanjiTest extends IdeogrammeTest
{
    public function getEntity(): Ideogramme
    {
        $entity = new Kanji;
        return $entity
            ->setLogo('改')
            ->setSignification('signification')
            ->setStroke(5)
            ->setKun('lecture kun')
            ->setReadOn('lecture ON')
            ->SetJlpt(4)
        ;
    }
}
