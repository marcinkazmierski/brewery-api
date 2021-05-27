<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\UserRegister;

use App\Application\Domain\Common\Response\AbstractResponse;
use App\Application\Domain\Entity\User;

/**
 * Class UserRegisterResponse
 * @package App\Application\Domain\UseCase\UserRegister
 */
class UserRegisterResponse extends AbstractResponse
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
