<?php

namespace App\Entity;

use App\Repository\KanjiKeyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KanjiKeyRepository::class)]
class KanjiKey extends Ideogramme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected int $id;

    #[ORM\Column(type: 'integer')]
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
