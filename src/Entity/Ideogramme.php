<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\IdeogrammeRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Symfony\Component\Serializer\Annotation\DiscriminatorMap;

#[ORM\Entity(repositoryClass: IdeogrammeRepository::class)]
#[InheritanceType('JOINED')]
#[DiscriminatorColumn(
    name: 'discr',
    type: 'string')
]
#[DiscriminatorMap(
    typeProperty: 'discr',
    mapping: ['ideogramme' => 'Ideogramme', 'kanji' => 'Kanji', 'kanjiKey' => 'KanjiKey'])
]
abstract class Ideogramme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected int $id;

    /**
     * Le kanji associé
     */
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    protected string $logo;

    #[ORM\Column(type: 'string', length: 255)]
    protected string $signification;

    /**
     * Le nombre de trait
     */
    #[ORM\Column(type: 'integer')]
    protected int $stroke;

    /**
     * La lecture kun : japonaise
     */
    #[ORM\Column(type: 'string', length: 255)]
    protected string $kun;

    /**
     * La lecture ON : sino-japonaise
     */
    #[ORM\Column(type: 'string', length: 255)]
    protected string $readOn;

    /**
     * L'image du kanji avec la numérotation des traits
     */
    #[ORM\OneToOne(targetEntity: Image::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    protected Image $image;

    /**
     * Le niveau JLPT allant de 1 à 5
     */
    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    protected ?string $jlpt;

    /**
     * Exemples de mots avec ce kanji
     */
    #[ORM\OneToMany(mappedBy: 'ideogramme', targetEntity: Example::class)]
    protected Collection $examples;

    /**
     * Liste des kanji similaire
     *
     * @var Collection
     */
    #[ORM\ManyToMany(targetEntity: self::class)]
    private Collection $similars;

    public function __construct()
    {
        $this->examples = new ArrayCollection();
        $this->similars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getSignification(): ?string
    {
        return $this->signification;
    }

    public function setSignification(string $signification): self
    {
        $this->signification = $signification;

        return $this;
    }

    public function getStroke(): ?int
    {
        return $this->stroke;
    }

    public function setStroke(int $stroke): self
    {
        $this->stroke = $stroke;

        return $this;
    }

    public function getKun(): ?string
    {
        return $this->kun;
    }

    public function setKun(string $kun): self
    {
        $this->kun = $kun;

        return $this;
    }

    public function getReadOn(): ?string
    {
        return $this->readOn;
    }

    public function setReadOn(string $readOn): self
    {
        $this->readOn = $readOn;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getJlpt(): ?string
    {
        return $this->jlpt;
    }

    public function setJlpt(?string $jlpt): self
    {
        $this->jlpt = $jlpt;

        return $this;
    }

    /**
     * @return Collection<int, Example>
     */
    public function getExamples(): Collection
    {
        return $this->examples;
    }

    public function addExample(Example $example): self
    {
        if (!$this->examples->contains($example)) {
            $this->examples[] = $example;
            $example->setIdeogramme($this);
        }

        return $this;
    }

    public function removeExample(Example $example): self
    {
        if ($this->examples->removeElement($example)) {
            // set the owning side to null (unless already changed)
            if ($example->getIdeogramme() === $this) {
                $example->setIdeogramme(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSimilars(): Collection
    {
        return $this->similars;
    }

    public function addSimilar(self $similar): self
    {
        if (!$this->similars->contains($similar)) {
            $this->similars[] = $similar;
        }

        return $this;
    }

    public function removeSimilar(self $similar): self
    {
        $this->similars->removeElement($similar);

        return $this;
    }
}
