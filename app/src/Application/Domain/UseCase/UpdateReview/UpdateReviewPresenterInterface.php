<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\UpdateReview;

/**
 * Interface UpdateReviewPresenterInterface
 * @package App\Application\Domain\UseCase\UpdateReview
 */
interface UpdateReviewPresenterInterface
{
    /**
     * @param UpdateReviewResponse $response
     */
    public function present(UpdateReviewResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
