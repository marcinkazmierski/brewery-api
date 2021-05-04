<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReviewRepository::class)
 * @ORM\Table(name="reviews")
 * @ApiResource(attributes={"security"="is_granted('ROLE_USER')"},collectionOperations={"get"={"normalization_context"={"groups"="review:list"}}}, itemOperations={"get"={"normalization_context"={"groups"="review:item"}}})
 */
class Review
{
    /**
     * @Groups({"review:list", "review:item", "beer:list", "beer:item"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"review:list", "review:item", "beer:list", "beer:item"})
     * @ORM\Column(type="float")
     */
    private $rating;

    /**
     * @Groups({"review:list", "review:item", "beer:list", "beer:item"})
     * @ORM\Column(type="string", length=2048)
     */
    private $text;

    /**
     * @Groups({"review:list", "review:item", "beer:list", "beer:item"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @Groups({"review:list", "review:item"})
     * @ORM\ManyToOne(targetEntity=Beer::class, inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $beer;

    /**
     * @Groups({"review:list", "review:item", "beer:list", "beer:item"})
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * Review constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getBeer(): ?Beer
    {
        return $this->beer;
    }

    public function setBeer(?Beer $beer): self
    {
        $this->beer = $beer;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
}
