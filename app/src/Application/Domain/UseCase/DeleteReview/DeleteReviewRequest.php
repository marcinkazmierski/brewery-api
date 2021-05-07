<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\DeleteReview;

use App\Application\Domain\Entity\User;

/**
 * Class DeleteReviewRequest
 * @package App\Application\Domain\UseCase\DeleteReview
 */
class DeleteReviewRequest
{
    /** @var User */
    private $user;

    /** @var int */
    private $reviewId;

    /**
     * DeleteReviewRequest constructor.
     * @param User $user
     * @param int $reviewId
     */
    public function __construct(User $user, int $reviewId)
    {
        $this->user = $user;
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
     * @return int
     */
    public function getReviewId(): int
    {
        return $this->reviewId;
    }
}
