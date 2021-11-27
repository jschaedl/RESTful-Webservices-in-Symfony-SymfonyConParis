<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

final class CreateAttendeeModel
{
    #[NotBlank]
    public string $firstname;

    #[NotBlank]
    public string $lastname;

    #[NotBlank]
    #[Email]
    public string $email;
}
