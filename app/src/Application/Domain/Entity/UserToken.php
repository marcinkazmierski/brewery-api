<?php

namespace App\Application\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Application\Infrastructure\Repository\UserTokenRepository")]
#[ORM\Table(name: "user_tokens")]
class UserToken {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: "integer")]
	private int $id;

	#[ORM\Column(type: "string", length: 255, unique: TRUE)]
	private ?string $tokenKey;


	#[ORM\Column(type: "datetime")]
	private \DateTime $createdAt;


	#[ORM\ManyToOne(targetEntity: User::class)]
	#[ORM\JoinColumn(nullable: FALSE, onDelete: "CASCADE")]
	private ?User $user;


	#[ORM\Column(type: "string", length: 255)]
	private ?string $appVersion;

	/**
	 * UserToken constructor.
	 */
	public function __construct() {
		$this->createdAt = new \DateTime();
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getTokenKey(): ?string {
		return $this->tokenKey;
	}

	public function setTokenKey(string $tokenKey): self {
		$this->tokenKey = $tokenKey;

		return $this;
	}

	public function getCreatedAt(): ?\DateTimeInterface {
		return $this->createdAt;
	}

	public function getUser(): ?User {
		return $this->user;
	}

	public function setUser(?User $user): self {
		$this->user = $user;

		return $this;
	}


	public function getAppVersion(): ?string {
		return $this->appVersion;
	}

	public function setAppVersion(string $appVersion): self {
		$this->appVersion = $appVersion;

		return $this;
	}

}
