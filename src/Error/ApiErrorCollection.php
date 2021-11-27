<?php

declare(strict_types=1);

namespace App\Error;

final class ApiErrorCollection
{
    private array $errors;

    public function addApiError(ApiError $error): self
    {
        $this->errors[] = $error;

        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
