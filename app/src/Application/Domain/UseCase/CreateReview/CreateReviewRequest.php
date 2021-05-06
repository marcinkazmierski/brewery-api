<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\CreateReview;

use App\Application\Domain\Entity\User;

/**
 * Class CreateReviewRequest
 * @package App\Application\Domain\UseCase\CreateReview
 */
class CreateReviewRequest
{
    /** @var User */
    private $user;

    /** @var float */
    private $rating;

    /** @var string */
    private $text;

    /** @var int */
    private $beerId;

    /**
     * CreateReviewRequest constructor.
     * @param User $user
     * @param float $rating
     * @param string $text
     * @param int $beerId
     */
    public function __construct(User $user, float $rating, string $text, int $beerId)
    {
        $this->user = $user;
        $this->rating = $rating;
        $this->text = $text;
        $this->beerId = $beerId;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return float
     */
    public function getRating(): float
    {
        return $this->rating;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getBeerId(): int
    {
        return $this->beerId;
    }
}
