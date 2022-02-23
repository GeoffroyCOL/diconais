<?php

namespace App\Entity;

use App\Repository\KanjiKeyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: KanjiKeyRepository::class)]
#[UniqueEntity('numberKey')]
class KanjiKey extends Ideogramme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected int $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Type(
        type: "integer",
        message: "La valeur {{ value }} n'est pas de type {{ type }}",
    )]
    #[Assert\Positive(
        message: "Le nombre de trait ne peut pas être négatif"
    )]
    protected int $numberKey;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberKey(): ?int
    {
        return $this->numberKey;
    }

    public function setNumberKey(int $numberKey): self
    {
        $this->numberKey = $numberKey;

        return $this;
    }
}
