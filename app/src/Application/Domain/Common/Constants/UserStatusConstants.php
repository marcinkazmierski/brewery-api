<?php
declare(strict_types=1);

namespace App\Application\Domain\Common\Constants;


final class UserStatusConstants
{
    const NEW = 0;
    const ACTIVE = 1;
    const GUEST = 2;
    const GUEST_WAIT_FOR_CONFIRMATION = 3;
    const BLOCKED = 99;
}