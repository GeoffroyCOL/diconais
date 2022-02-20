<?php

namespace App\Entity;

use App\Repository\KanjiRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KanjiRepository::class)]
class Kanji extends Ideogramme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected int $id;

    #[ORM\ManyToOne(targetEntity: KanjiKey::class)]
    private ?KanjiKey $kanjiKey;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKanjiKey(): ?KanjiKey
    {
        return $this->kanjiKey;
    }

    public function setKanjiKey(?KanjiKey $kanjiKey): self
    {
        $this->kanjiKey = $kanjiKey;

        return $this;
    }
}
