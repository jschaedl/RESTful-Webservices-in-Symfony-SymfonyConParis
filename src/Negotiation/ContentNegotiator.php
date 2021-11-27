<?php

declare(strict_types=1);

namespace App\Negotiation;

use Negotiation\Negotiator;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

final class ContentNegotiator
{
    private const SUPPORTED_MIME_TYPES = [
        MimeType::JSON,
        MimeType::JSON_HAL,
        MimeType::XML,
    ];

    private Negotiator $negotiator;

    public function __construct(
        private RequestStack $requestStack
    ) {
        $this->negotiator = new Negotiator();
    }

    public function isNegotiatedRequestFormat(string $format): bool
    {
        return $format === $this->getNegotiatedRequestFormat();
    }

    // this is used to set the correct serialization format
    public function getNegotiatedRequestFormat(): string
    {
        $acceptableContentTypes = $this->requestStack->getCurrentRequest()->getAcceptableContentTypes();

        $mimeType = $this->getNegotiatedMimeType($acceptableContentTypes);

        if (!$mimeType || !in_array($mimeType, self::SUPPORTED_MIME_TYPES, true)) {
            throw $this->getNotAcceptableHttpException($acceptableContentTypes, self::SUPPORTED_MIME_TYPES);
        }

        return match ($mimeType) {
            MimeType::JSON_HAL => RequestFormat::JSON_HAL,
            MimeType::XML => RequestFormat::XML,
            default => RequestFormat::JSON,
        };
    }

    private function getNegotiatedMimeType(array $acceptableContentTypes): ?string
    {
        // default is application/json
        if (empty($acceptableContentTypes)) {
            return MimeType::JSON;
        }

        // default is application/json
        if (1 === count($acceptableContentTypes) && '*/*' === $acceptableContentTypes[0]) {
            return MimeType::JSON;
        }

        $acceptableContentTypesAsString = implode(',', $acceptableContentTypes);

        $acceptHeader = $this->negotiator->getBest($acceptableContentTypesAsString, self::SUPPORTED_MIME_TYPES);

        return $acceptHeader?->getType();
    }

    private function getNotAcceptableHttpException(array $accepts, array $mimeTypes): NotAcceptableHttpException
    {
        return new NotAcceptableHttpException(sprintf(
            'Requested format "%s" is not supported. Supported MIME types are "%s".',
            implode('", "', $accepts),
            implode('", "', $mimeTypes)
        ));
    }
}
