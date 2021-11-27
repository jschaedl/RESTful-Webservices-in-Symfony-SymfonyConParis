<?php

declare(strict_types=1);

namespace App\Domain\Model;

use OpenApi\Annotations\Property;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final class CreateAttendeeModel
{
    // be aware that deprecating properties means you still need to support both ways of creating attendees
    // and that you need to move validation into your domain layer

    /**
     * @Property(deprecated=true, description="Property firstname is deprecated, use property name instead.")
     */
    #[NotBlank(allowNull: true)]
    public string $firstname;

    /**
     * @Property(deprecated=true, description="Property lastname is deprecated, use property name instead.")
     */
    #[NotBlank(allowNull: true)]
    public string $lastname;

    #[NotBlank(allowNull: true)]
    public string $name;

    #[NotBlank]
    #[Email]
    public string $email;

    #[Callback]
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if ((empty($this->firstname) || empty($this->lastname)) && empty($this->name)) {
            $context->buildViolation('Passing values for fields "$firstname" and "$lastname" is deprecated. Pass a value for field "$name" instead.')
                ->atPath('firstname')
                ->addViolation();
        }
    }
}
