<?php

declare(strict_types=1);

namespace App\ArgumentValueResolver;

use App\Domain\Model\CreateWorkshopModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CreateWorkshopModelResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return CreateWorkshopModel::class === $argument->getType() && 'POST' === $request->getMethod();
    }

    /**
     * @return iterable<CreateWorkshopModel>
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $model = $this->serializer->deserialize(
            $request->getContent(),
            CreateWorkshopModel::class,
            $request->getRequestFormat(),
        );

        $validationErrors = $this->validator->validate($model);

        if (\count($validationErrors) > 0) {
            throw new ValidationFailedException($model, $validationErrors);
        }

        yield $model;
    }
}
