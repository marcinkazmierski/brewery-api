<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\GetUserProfile;

use App\Application\Domain\Common\Response\AbstractResponse;
use App\Application\Domain\Entity\User;

/**
 * Class GetUserProfileResponse
 * @package App\Application\Domain\UseCase\GetUserProfile
 */
class GetUserProfileResponse extends AbstractResponse
{
    /** @var User */
    private User $user;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
