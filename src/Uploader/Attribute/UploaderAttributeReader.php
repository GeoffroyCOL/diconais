<?php

namespace App\Uploader\Attribute;

use App\Uploader\Attribute\UploaderField;
use Doctrine\ORM\Mapping\Driver\AttributeReader;

class UploaderAttributeReader
{
    public function __construct(private AttributeReader $reader)
    {}

    public function isUploadable(Object $entity): bool
    {
        $reflection = new \ReflectionClass($entity);
        return $this->reader->getClassAnnotation($reflection, Uploader::class) !== null;
    }

    public function getUploaderFields(Object $entity): array
    {
        $reflection = new \ReflectionClass(get_class($entity));
        if (!$this->isUploadable($entity)) {
            return [];
        }
        $properties = [];
        foreach($reflection->getProperties() as $property) {
            $annotation = $this->reader->getPropertyAnnotation($property, UploaderField::class);
            if ($annotation !== null) {
                $properties[$property->getName()] = $annotation;
            }
        }
        return $properties;
    }
}