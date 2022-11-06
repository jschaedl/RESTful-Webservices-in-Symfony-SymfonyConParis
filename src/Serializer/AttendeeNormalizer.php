<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Entity\Attendee;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

final class AttendeeNormalizer implements ContextAwareNormalizerInterface
{
    public function __construct(
        private ObjectNormalizer $normalizer
    ) {
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Attendee;
    }

    /**
     * @param Attendee $object
     *
     * @return array|string
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $customContext = [
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['id'],
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => fn ($object, $format, $context) => $object->getFirstname().' '.$object->getLastname(),
        ];

        $context = array_merge($context, $customContext);

        return $this->normalizer->normalize($object, $format, $context);
    }
}
