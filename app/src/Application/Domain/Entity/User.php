<?php
declare(strict_types=1);

namespace App\Application\Domain\Entity;

use App\Application\Domain\Common\Constants\UserStatusConstants;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Application\Infrastructure\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true)
     */
    private string $nick;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true)
     */
    private string $email;

    /**
     * @var ?string
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $password;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", options={"default" = "CURRENT_TIMESTAMP"})
     */
    private \DateTime $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="owner", orphanRemoval=true)
     */
    private Collection $reviews;

    /**
     * @ORM\ManyToMany(targetEntity=Beer::class, inversedBy="allowedUsers")
     */
    private Collection $unlockedBeers;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private int $status = UserStatusConstants::NEW;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->reviews = new ArrayCollection();
        $this->unlockedBeers = new ArrayCollection();
    }

    /**
     * Returns the roles or permissions granted to the user for security.
     */
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * {@inheritdoc}
     */
    public function getSalt(): ?string
    {
        // we're using bcrypt in security.yml to encode the password, so
        // the salt value is built-in and you don't have to generate one

        return null;
    }


    /**
     * @return string
     */
    public function getUsername(): string // interface
    {
        return (string)$this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * {@inheritdoc}
     */
    public function eraseCredentials(): void
    {
        // if you had a plainPassword property, you'd nullify it here
        // $this->plainPassword = null;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNick(): string
    {
        return $this->nick;
    }

    /**
     * @param string $nick
     */
    public function setNick(string $nick): void
    {
        $this->nick = $nick;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
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
            $review->setOwner($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getOwner() === $this) {
                $review->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Beer[]
     */
    public function getUnlockedBeers(): Collection
    {
        return $this->unlockedBeers;
    }

    public function addUnlockedBeer(Beer $unlockedBeer): self
    {
        if (!$this->unlockedBeers->contains($unlockedBeer)) {
            $this->unlockedBeers[] = $unlockedBeer;
        }

        return $this;
    }

    public function removeUnlockedBeer(Beer $unlockedBeer): self
    {
        $this->unlockedBeers->removeElement($unlockedBeer);

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }
}