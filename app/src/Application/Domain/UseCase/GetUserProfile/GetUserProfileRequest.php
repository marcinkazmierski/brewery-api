<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\GetUserProfile;

use App\Application\Domain\Entity\User;

/**
 * Class GetUserProfileRequest
 * @package App\Application\Domain\UseCase\GetUserProfile
 */
class GetUserProfileRequest
{
    /** @var User */
    private User $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
