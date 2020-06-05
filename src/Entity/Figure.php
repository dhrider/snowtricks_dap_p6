<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FigureRepository")
 * @UniqueEntity(
 *     fields={"name"}
 * )
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
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     * @return Figure
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FiguresGroup", inversedBy="figures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $figuresGroup;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="figure", cascade={"all"}, fetch="EAGER", orphanRemoval=true)
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Link", mappedBy="figure", cascade={"all"}, fetch="EAGER", orphanRemoval=true)
     */
    private $links;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="figure",  cascade={"all"}, fetch="EAGER", orphanRemoval=true)
     */
    private $comments;


    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTime();
        $this->images = new ArrayCollection();
        $this->links = new ArrayCollection();
        $this->comments = new ArrayCollection();
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Link[]
     */
    public function getLinks() : Collection
    {
        return $this->links;
    }

    /**
     * @param Collection $link
     */
    public function setLinks(Collection $link): void
    {
        $this->$link = $link;
    }

    public function addLink(Link $link) : self
    {
        if (!$this->links->contains($link)) {
            $this->links[] = $link;
            $link->setFigure($this);
        }

        return $this;
    }

    public function removeLink(Link $link) : self
    {
        if ($this->links->contains($link)) {
            $this->links->removeElement($link);
            // set the owning side to null (unless already changed)
            if ($link->getFigure() === $this) {
                $link->setFigure(null);
            }
        }

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

    public function getFirstImageId() : int
    {
        return $this->getImages()->first()->getId();
    }

    public function countImages() : int
    {
        return $this->getImages()->count();
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setFigure($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getFigure() === $this) {
                $comment->setFigure(null);
            }
        }

        return $this;
    }
}
