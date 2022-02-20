<?php

/**
 * Fournit une image pour les fixtures
 */

namespace App\DataFixtures\Faker\Provider;

use App\Entity\Image;
use App\Entity\Media;

class ImageProvider
{
    public static function imageProvider(): Media
    {
        $image = new Image();
        return $image->setPath('img-path-' . \uniqid());
    }
}
