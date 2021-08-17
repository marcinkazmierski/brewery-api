<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\GetUserProfile;

/**
 * Interface GetUserProfilePresenterInterface
 * @package App\Application\Domain\UseCase\GetUserProfile
 */
interface GetUserProfilePresenterInterface
{
    /**
     * @param GetUserProfileResponse $response
     */
    public function present(GetUserProfileResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
