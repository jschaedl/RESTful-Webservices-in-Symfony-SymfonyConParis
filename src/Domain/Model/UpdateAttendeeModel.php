<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

final class UpdateAttendeeModel
{
    #[NotBlank(allowNull: true)]
    public ?string $firstname = null;

    #[NotBlank(allowNull: true)]
    public ?string $lastname = null;

    #[NotBlank(allowNull: true)]
    #[Email]
    public ?string $email = null;
}
