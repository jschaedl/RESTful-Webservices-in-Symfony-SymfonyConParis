<?php

declare(strict_types=1);

namespace App\ArgumentValueResolver;

use App\Domain\Model\CreateAttendeeModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CreateAttendeeModelResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return CreateAttendeeModel::class === $argument->getType() && 'POST' === $request->getMethod();
    }

    /**
     * @return iterable<CreateAttendeeModel>
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        try {
            $model = $this->serializer->deserialize(
                $request->getContent(),
                CreateAttendeeModel::class,
                $request->getRequestFormat(),
            );
        } catch (\Exception $exception) {
            throw new UnprocessableEntityHttpException();
        }

        $validationErrors = $this->validator->validate($model);

        if (\count($validationErrors) > 0) {
            // throw a UnprocessableEntityHttpException for now, we will introduce proper ApiExceptions later
            throw new UnprocessableEntityHttpException();
        }

        yield $model;
    }
}
