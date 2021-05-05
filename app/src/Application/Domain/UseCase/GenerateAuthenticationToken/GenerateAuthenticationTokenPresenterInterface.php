<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\GenerateAuthenticationToken;

/**
 * Interface GenerateAuthenticationTokenPresenterInterface
 * @package App\Application\Domain\UseCase\GenerateAuthenticationToken
 */
interface GenerateAuthenticationTokenPresenterInterface
{
    /**
     * @param GenerateAuthenticationTokenResponse $response
     */
    public function present(GenerateAuthenticationTokenResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
