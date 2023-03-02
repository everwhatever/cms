<?php

declare(strict_types=1);

namespace App\User\Application\Message\Command;

use App\User\Domain\Model\UserAdditionalInfo;

class UpdateUserInfoMessage
{
    public function __construct(public readonly UserAdditionalInfo $userAdditionalInfo)
    {
    }
}