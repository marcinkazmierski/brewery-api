<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\DeleteReview;

use App\Application\Domain\Common\Response\AbstractResponse;
use App\Application\Domain\Entity\Beer;
use App\Application\Domain\Entity\User;

/**
 * Class DeleteReviewResponse
 * @package App\Application\Domain\UseCase\DeleteReview
 */
class DeleteReviewResponse extends AbstractResponse
{
    /** @var Beer */
    private Beer $beer;

    /** @var User */
    private User $owner;

    /**
     * @return Beer
     */
    public function getBeer(): Beer
    {
        return $this->beer;
    }

    /**
     * @param Beer $beer
     */
    public function setBeer(Beer $beer): void
    {
        $this->beer = $beer;
    }

    /**
     * @return User
     */
    public function getOwner(): User
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     */
    public function setOwner(User $owner): void
    {
        $this->owner = $owner;
    }

}
