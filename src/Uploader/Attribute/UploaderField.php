<?php

namespace App\Uploader\Attribute;

use Doctrine\ORM\Mapping\Annotation;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class UploaderField implements Annotation
{
    public function __construct(
        private string $propertyName
    )
    {}

    public function getPropertyName(): string
    {
        return $this->propertyName;
    }
}
