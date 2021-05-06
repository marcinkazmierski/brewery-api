<?php

namespace App\Application\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass="App\Application\Infrastructure\Repository\ReviewRepository")
 * @ORM\Table(name="reviews",
 *    uniqueConstraints={
 *        @UniqueConstraint(name="vreview_unique",
 *            columns={"owner_id", "beer_id"})
 *    }
 * )
 */
class Review
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $rating;

    /**
     * @ORM\Column(type="string", length=2048)
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity=Beer::class, inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $beer;

    /**
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
