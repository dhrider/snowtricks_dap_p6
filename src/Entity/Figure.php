<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FigureRepository")
 */
class Figure
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateLastModification;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FiguresGroup", inversedBy="figures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $figuresGroup;


    public function __construct()
    {
        $this->dateCreation = new \DateTimeImmutable();
        $this->dateLastModification = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateLastModification(): ?\DateTimeInterface
    {
        return $this->dateLastModification;
    }

    public function setDateLastModification(\DateTimeInterface $dateLastModification): self
    {
        $this->dateLastModification = $dateLastModification;

        return $this;
    }

    public function getFiguresGroup(): ?FiguresGroup
    {
        return $this->figuresGroup;
    }

    public function setFiguresGroup(?FiguresGroup $figuresGroup): self
    {
        $this->figuresGroup = $figuresGroup;

        return $this;
    }
}
