<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\IdeogrammeRepository;
use App\Uploader\Attribute\UploaderField;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\DiscriminatorMap;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

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
#[UniqueEntity('logo')]
abstract class Ideogramme
{
    const LAST_KANJI = 6;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected int $id;

    /**
     * Le kanji associé
     */
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank]
    protected string $logo = '';

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    protected string $signification = '';

    /**
     * Le nombre de trait
     */
    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank]
    #[Assert\Positive(
        message: "Le nombre de trait ne peut pas être négatif"
    )]
    #[Assert\Type(
        type: "integer",
        message: "La valeur {{ value }} n'est pas de type {{ type }}",
    )]
    protected int $stroke = 1;

    /**
     * La lecture kun : japonaise
     */
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    protected string $kun = '';

    /**
     * La lecture ON : sino-japonaise
     */
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    protected string $readOn = '';

    /**
     * L'image du kanji avec la numérotation des traits
     */
    #[ORM\OneToOne(targetEntity: Image::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[UploaderField(propertyName: 'path')]
    #[Assert\Valid]
    protected ?Image $image = null;

    /**
     * Le niveau JLPT allant de 1 à 5
     */
    #[ORM\Column(type: 'integer', length: 50, nullable: true)]
    #[Assert\Range(
        min: 1,
        max: 5,
        notInRangeMessage: 'Le niveau du JLPT doit être contenue entre {{ min }} et {{ max }}',
    )]
    protected ?int $jlpt = null;

    /**
     * Exemples de mots avec ce kanji
     */
    #[ORM\OneToMany(mappedBy: 'ideogramme', targetEntity: Example::class, cascade: ["persist", "remove"])]
    #[Assert\Valid]
    protected Collection $examples;

    /**
     * Liste des kanji similaire
     *
     * @var Collection
     */
    #[ORM\ManyToMany(targetEntity: self::class)]
    protected Collection $similars;

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

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getJlpt(): ?int
    {
        return $this->jlpt;
    }

    public function setJlpt(?int $jlpt): self
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

    public function __toString()
    {
        return $this->logo;
    }
}
