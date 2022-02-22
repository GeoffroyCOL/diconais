<?php

namespace App\Uploader\Handler;

use App\Entity\Media;
use App\Uploader\Attribute\UploaderField;
use App\Uploader\Exception\PropertyNotFoundException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UploaderHandler
{
    private string $filename;

    public function __construct(private string $targetDirectory, private SluggerInterface $slugger)
    {}

    public function persist(Media $media, UploaderField $annotation): void
    {
        /** @var UploadedFile $file */
        $file = $media->getImageFile();

        $this->existsPropertyName($media, $annotation->getPropertyName());
        $this->setFilename($file);
        $this->setValueProperty($media, $annotation->getPropertyName());
        $this->upload($file);
    }

    public function update(Media $media, UploaderField $annotation): void
    {
        if (null != $media->getPath()) {
            $oldFilename = $media->getPath();
            $this->persist($media, $annotation);
            $this->removefile($oldFilename);
        }
    }

    public function remove(Media $media): void
    {
        if (null != $media->getPath()) {
            $this->removefile($media->getPath());
        }
    }
    
    /**
     * existsPropertyName
     * Vérifie que $property existe dans $media
     *
     * @param  Media $media
     * @param  string $property
     * @return void
     */
    private function existsPropertyName(Media $media, string $property): void
    {
        if (! property_exists($media, $property)) {
            throw new PropertyNotFoundException(\sprintf("La propriété n'existe %s n'existe pas pour la classe %s", $property, $media));
        }
    }
    
    /**
     * setValueProperty
     * Ajoute la valeur du imageFile pour $media
     *
     * @param  Media $media
     * @param  string $property
     * @return void
     */
    private function setValueProperty(Media $media, string $property): void
    {
        $method = 'set' . \ucfirst($property);
        $media->$method($this->filename);
    }
    
    /**
     * setFilename
     * Génère le filename pour le media
     *
     * @param  UploadedFile $file
     * @return void
     */
    private function setFilename(UploadedFile $file): void
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $this->filename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
    }
    
    /**
     * upload
     * Déplace le fichier dans le dossier $targetDirectory
     *
     * @param  UploadedFile $file
     * @return void
     */
    private function upload(UploadedFile $file): void
    {
        try {
            $file->move($this->getTargetDirectory(), $this->filename);
        } catch (FileException $e) {
        }
    }
    
    /**
     * getTargetDirectory
     *
     * @return string
     */
    private function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
    
    /**
     * removeFile
     * Supprime le media contenued dans le dossier $templateDirectory
     * 
     * @param  string $oldFilename
     * @return void
     */
    private function removeFile(string $oldFilename): void
    {
        $file = $this->getTargetDirectory() .'/'. $oldFilename;
        if (\file_exists($file)) {
            unlink($file);
        }
    }
}