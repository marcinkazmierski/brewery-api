<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\CreateReview;

/**
 * Interface CreateReviewPresenterInterface
 * @package App\Application\Domain\UseCase\CreateReview
 */
interface CreateReviewPresenterInterface
{
    /**
     * @param CreateReviewResponse $response
     */
    public function present(CreateReviewResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
