<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\UpdateReview;

use App\Application\Domain\Entity\User;

/**
 * Class UpdateReviewRequest
 * @package App\Application\Domain\UseCase\UpdateReview
 */
class UpdateReviewRequest
{
    /** @var User */
    private User $user;

    /** @var float */
    private float $rating;

    /** @var string */
    private string $text;

    /** @var int */
    private int $reviewId;

    /**
     * UpdateReviewRequest constructor.
     * @param User $user
     * @param float $rating
     * @param string $text
     * @param int $reviewId
     */
    public function __construct(User $user, float $rating, string $text, int $reviewId)
    {
        $this->user = $user;
        $this->rating = $rating;
        $this->text = $text;
        $this->reviewId = $reviewId;
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
    public function getReviewId(): int
    {
        return $this->reviewId;
    }
}
