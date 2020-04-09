<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Array_;
use PhpParser\Node\Scalar\String_;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="json")
     */
    private $videoLinks;

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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="figure", cascade={"all"}, fetch="EAGER", orphanRemoval=true)
     */
    private $images;


    public function __construct()
    {
        $this->dateCreation = new \DateTimeImmutable();
        $this->dateLastModification = new \DateTime();
        $this->images = new ArrayCollection();
        $this->videoLinks = array();
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

    public function getVideoLinks() : array
    {
        return $this->videoLinks;
    }

    public function setVideoLinks(array $videoLinks): void
    {
        $this->videoLinks = $videoLinks;
    }

    public function addVideoLink(string $videoLink) : self
    {
        $this->videoLinks[] = $videoLink;

        return $this;
    }

    public function removeVideoLink(string $videoLink) : self
    {
        unset($this->videoLinks[$videoLink]);

        $this->videoLinks = array_values($this->videoLinks);

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

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    /**
     * @param Collection $image
     */
    public function setImages(Collection $image): void
    {
        $this->$image = $image;
    }


    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setFigure($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getFigure() === $this) {
                $image->setFigure(null);
            }
        }

        return $this;
    }

    public function getFirstImage() : string
    {
        return $this->getImages()->first()->getImagePath();
    }
}
