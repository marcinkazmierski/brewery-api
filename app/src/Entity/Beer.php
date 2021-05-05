<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\BeerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BeerRepository::class)
 * @ORM\Table(name="beers")
 * @ApiResource(attributes={"security"="is_granted('ROLE_USER')"},collectionOperations={"get"={"normalization_context"={"groups"="beer:list"}}}, itemOperations={"get"={"normalization_context"={"groups"="beer:item"}}})
 */
class Beer
{
    /**
     * @Groups({"beer:list", "beer:item"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"beer:list", "beer:item"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Groups({"beer:list", "beer:item"})
     * @ORM\Column(type="string", length=2048)
     */
    private $description;

    /**
     * @Groups({"beer:list", "beer:item"})
     * @ORM\Column(type="string", length=1024)
     */
    private $malts;

    /**
     * @Groups({"beer:list", "beer:item"})
     * @ORM\Column(type="string", length=1024)
     */
    private $hops;

    /**
     * @ORM\Column(type="integer")
     */
    private $status = 1;

    /**
     * @Groups({"beer:list", "beer:item"})
     * @ORM\Column(type="array")
     */
    private $tags = [];

    /**
     * @Groups({"beer:list", "beer:item"})
     * @ORM\Column(type="string", length=255)
     */
    private $icon;

    /**
     * @Groups({"beer:list", "beer:item", "review:item:add"})
     * @ORM\Column(type="string", length=512, unique=true)
     */
    private $code;

    /**
     * @Groups({"beer:list", "beer:item"})
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="beer", orphanRemoval=true)
     */
    private $reviews;

    /**
     * @Groups({"beer:list", "beer:item"})
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Groups({"beer:list", "beer:item"})
     * @ORM\Column(type="string", length=255)
     */
    private $backgroundImage;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="unlockedBeers")
     */
    private $allowedUsers;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->allowedUsers = new ArrayCollection();
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

    public function getMalts(): ?string
    {
        return $this->malts;
    }

    public function setMalts(string $malts): self
    {
        $this->malts = $malts;

        return $this;
    }

    public function getHops(): ?string
    {
        return $this->hops;
    }

    public function setHops(string $hops): self
    {
        $this->hops = $hops;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setBeer($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getBeer() === $this) {
                $review->setBeer(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getBackgroundImage(): ?string
    {
        return $this->backgroundImage;
    }

    public function setBackgroundImage(string $backgroundImage): self
    {
        $this->backgroundImage = $backgroundImage;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getAllowedUsers(): Collection
    {
        return $this->allowedUsers;
    }

    public function addAllowedUser(User $allowedUser): self
    {
        if (!$this->allowedUsers->contains($allowedUser)) {
            $this->allowedUsers[] = $allowedUser;
            $allowedUser->addUnlockedBeer($this);
        }

        return $this;
    }

    public function removeAllowedUser(User $allowedUser): self
    {
        if ($this->allowedUsers->removeElement($allowedUser)) {
            $allowedUser->removeUnlockedBeer($this);
        }

        return $this;
    }
}
