<?php

declare(strict_types=1);

namespace App\Domain\Exception;

final class AttendeeAlreadyAttendsOtherWorkshopOnThatDateException extends \RuntimeException
{
    public function __construct($code = 0, \Throwable $previous = null)
    {
        parent::__construct('Attendee already attends another workshop on that date.', $code, $previous);
    }
}
