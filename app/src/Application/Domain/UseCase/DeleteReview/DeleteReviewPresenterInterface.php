<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\DeleteReview;

/**
 * Interface DeleteReviewPresenterInterface
 * @package App\Application\Domain\UseCase\DeleteReview
 */
interface DeleteReviewPresenterInterface
{
    /**
     * @param DeleteReviewResponse $response
     */
    public function present(DeleteReviewResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
