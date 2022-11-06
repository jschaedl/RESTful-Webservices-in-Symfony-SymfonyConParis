<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Error\ApiError;
use App\Error\ApiErrorCollection;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[AsEventListener(event: KernelEvents::EXCEPTION, method: 'onKernelException')]
class ExceptionListener
{
    public function __construct(
        private SerializerInterface $serializer
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        if ($throwable instanceof NotEncodableValueException) {
            $errorCollection = $this->handleNotEncodableValueException($throwable);
        }

        if ($throwable instanceof ValidationFailedException) {
            $errorCollection = $this->handleValidationFailedException($throwable);
        }

        $serializedErrors = $this->serializer->serialize($errorCollection, $event->getRequest()->getRequestFormat());

        $event->setResponse(new Response($serializedErrors, Response::HTTP_UNPROCESSABLE_ENTITY));
    }

    private function handleValidationFailedException(ValidationFailedException $validationFailedException): ApiErrorCollection
    {
        $errorCollection = new ApiErrorCollection();

        /* @var ConstraintViolationInterface $violation */
        foreach ($validationFailedException->getViolations() as $violation) {
            $errorCollection->addApiError(
                new ApiError(
                    'Validation failed.',
                    $violation->getPropertyPath().': '.$violation->getMessage()
                )
            );
        }

        return $errorCollection;
    }

    private function handleNotEncodableValueException(NotEncodableValueException $notEncodableValueException): ApiErrorCollection
    {
        $errorCollection = new ApiErrorCollection();

        $errorCollection->addApiError(
            new ApiError(
                'Encoding failed.',
                $notEncodableValueException->getMessage()
            )
        );

        return $errorCollection;
    }
}
