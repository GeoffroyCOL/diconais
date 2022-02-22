<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\KanjiRepository;
use App\Uploader\Attribute\Uploader;

#[ORM\Entity(repositoryClass: KanjiRepository::class)]
#[Uploader]
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
