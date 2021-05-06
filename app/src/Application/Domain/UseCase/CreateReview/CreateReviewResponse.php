<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\CreateReview;

use App\Application\Domain\Common\Response\AbstractResponse;
use App\Application\Domain\Entity\Review;

/**
 * Class CreateReviewResponse
 * @package App\Application\Domain\UseCase\CreateReview
 */
class CreateReviewResponse extends AbstractResponse
{
    /** @var Review */
    private $review;

    /**
     * @return Review
     */
    public function getReview(): Review
    {
        return $this->review;
    }

    /**
     * @param Review $review
     */
    public function setReview(Review $review): void
    {
        $this->review = $review;
    }
}
