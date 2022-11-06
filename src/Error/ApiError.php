<?php

declare(strict_types=1);

namespace App\Error;

final class ApiError
{
    public function __construct(
        private string $message,
        private string $detail
    ) {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getDetail(): string
    {
        return $this->detail;
    }
}
