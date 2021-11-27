<?php

declare(strict_types=1);

namespace App\Domain\Exception;

final class AttendeeLimitReachedException extends \RuntimeException
{
    public function __construct($code = 0, \Throwable $previous = null)
    {
        parent::__construct('Attendee limit reached.', $code, $previous);
    }
}
