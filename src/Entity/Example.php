<?php

namespace App\Entity;

use App\Repository\ExampleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExampleRepository::class)]
class Example
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $list;

    #[ORM\ManyToOne(targetEntity: Ideogramme::class, inversedBy: 'examples')]
    private ?Ideogramme $ideogramme;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getList(): ?string
    {
        return $this->list;
    }

    public function setList(string $list): self
    {
        $this->list = $list;

        return $this;
    }

    public function getIdeogramme(): ?Ideogramme
    {
        return $this->ideogramme;
    }

    public function setIdeogramme(?Ideogramme $ideogramme): self
    {
        $this->ideogramme = $ideogramme;

        return $this;
    }
}
