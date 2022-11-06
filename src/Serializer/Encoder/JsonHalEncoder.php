<?php

declare(strict_types=1);

namespace App\Serializer\Encoder;

use Symfony\Component\Serializer\Encoder\JsonEncoder;

final class JsonHalEncoder extends JsonEncoder
{
    public const FORMAT = 'jsonhal';

    public function supportsEncoding(string $format)
    {
        return self::FORMAT === $format;
    }
}
