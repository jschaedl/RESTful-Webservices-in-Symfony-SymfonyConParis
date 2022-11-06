<?php

declare(strict_types=1);

namespace App\Domain\Model;

final class UpdateAttendeeModel
{
    public ?string $firstname = null;
    public ?string $lastname = null;
    public ?string $email = null;
}
