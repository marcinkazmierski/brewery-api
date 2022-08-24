<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\StoreNotificationToken;

/**
 * Interface StoreNotificationTokenPresenterInterface
 * @package App\Application\Domain\UseCase\StoreNotificationToken
 */
interface StoreNotificationTokenPresenterInterface
{
    /**
     * @param StoreNotificationTokenResponse $response
     */
    public function present(StoreNotificationTokenResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
