<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\GenerateAuthenticationGuestToken;

/**
 * Interface GenerateAuthenticationGuestTokenPresenterInterface
 * @package App\Application\Domain\UseCase\GenerateAuthenticationGuestToken
 */
interface GenerateAuthenticationGuestTokenPresenterInterface
{
    /**
     * @param GenerateAuthenticationGuestTokenResponse $response
     */
    public function present(GenerateAuthenticationGuestTokenResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
