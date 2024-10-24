<?php

namespace App\Application\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Application\Infrastructure\Repository\BeerRepository")]
#[ORM\Table(name: "beers")]
class Beer {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: "integer")]
	private int $id;


	#[ORM\Column(type: "string", length: 255)]
	private string $name = "";


	#[ORM\Column(type: "string", length: 255)]
	private string $title = "";


	#[ORM\Column(type: "string", length: 2048)]
	private string $description;


	#[ORM\Column(type: "string", length: 1024)]
	private string $malts;


	#[ORM\Column(type: "string", length: 1024)]
	private string $hops;


	#[ORM\Column(type: "boolean")]
	private bool $status = TRUE;


	#[ORM\Column(type: "boolean")]
	private bool $activeForAllUsers = FALSE;


	#[ORM\Column(type: "json")]
	private ?array $tags = [];


	#[ORM\Column(type: "string", length: 255)]
	private string $icon;


	#[ORM\Column(type: "string", length: 512, unique: TRUE)]
	private string $code;


	#[ORM\OneToMany(targetEntity: Review::class, mappedBy: "beer", orphanRemoval: TRUE)]
	#[ORM\OrderBy(["createdAt" => "DESC"])]
	private Collection $reviews;


	#[ORM\Column(type: "datetime")]
	private \DateTime $createdAt;


	#[ORM\Column(type: "string", length: 255)]
	private string $backgroundImage;


	#[ORM\ManyToMany(targetEntity: User::class, mappedBy: "unlockedBeers")]
	private Collection $allowedUsers;

	public function __construct() {
		$this->reviews = new ArrayCollection();
		$this->createdAt = new \DateTime();
		$this->allowedUsers = new ArrayCollection();
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getName(): string {
		return $this->name;
	}

	public function setName(string $name): self {
		$this->name = $name;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle(): string {
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle(string $title): void {
		$this->title = $title;
	}


	public function getDescription(): ?string {
		return $this->description;
	}

	public function setDescription(string $description): self {
		$this->description = $description;

		return $this;
	}

	public function getMalts(): ?string {
		return $this->malts;
	}

	public function setMalts(string $malts): self {
		$this->malts = $malts;

		return $this;
	}

	public function getHops(): ?string {
		return $this->hops;
	}

	public function setHops(string $hops): self {
		$this->hops = $hops;

		return $this;
	}

	public function getStatus(): ?bool {
		return $this->status;
	}

	public function setStatus(bool $status): self {
		$this->status = $status;

		return $this;
	}

	public function getTags(): ?array {
		return array_values($this->tags??[]);
	}

	public function setTags(array $tags): self {
		$this->tags = $tags;

		return $this;
	}

	public function getIcon(): ?string {
		return $this->icon;
	}

	public function setIcon(string $icon): self {
		$this->icon = $icon;

		return $this;
	}

	public function getCode(): ?string {
		return $this->code;
	}

	public function setCode(string $code): self {
		$this->code = $code;

		return $this;
	}

	/**
	 * @return Collection|Review[]
	 */
	public function getReviews(): Collection {
		return $this->reviews;
	}

	public function addReview(Review $review): self {
		if (!$this->reviews->contains($review)) {
			$this->reviews[] = $review;
			$review->setBeer($this);
		}

		return $this;
	}

	public function removeReview(Review $review): self {
		if ($this->reviews->removeElement($review)) {
			// set the owning side to null (unless already changed)
			if ($review->getBeer() === $this) {
				$review->setBeer(NULL);
			}
		}

		return $this;
	}

	public function getCreatedAt(): ?\DateTimeInterface {
		return $this->createdAt;
	}

	public function getBackgroundImage(): ?string {
		return $this->backgroundImage;
	}

	public function setBackgroundImage(string $backgroundImage): self {
		$this->backgroundImage = $backgroundImage;

		return $this;
	}

	/**
	 * @return Collection|User[]
	 */
	public function getAllowedUsers(): Collection {
		return $this->allowedUsers;
	}

	public function addAllowedUser(User $allowedUser): self {
		if (!$this->allowedUsers->contains($allowedUser)) {
			$this->allowedUsers[] = $allowedUser;
			$allowedUser->addUnlockedBeer($this);
		}

		return $this;
	}

	public function removeAllowedUser(User $allowedUser): self {
		if ($this->allowedUsers->removeElement($allowedUser)) {
			$allowedUser->removeUnlockedBeer($this);
		}

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isActiveForAllUsers(): bool {
		return $this->activeForAllUsers;
	}

	/**
	 * @param bool $activeForAllUsers
	 */
	public function setActiveForAllUsers(bool $activeForAllUsers): void {
		$this->activeForAllUsers = $activeForAllUsers;
	}

	/**
	 * @param \DateTime $createdAt
	 */
	public function setCreatedAt(\DateTime $createdAt): void {
		$this->createdAt = $createdAt;
	}

}
