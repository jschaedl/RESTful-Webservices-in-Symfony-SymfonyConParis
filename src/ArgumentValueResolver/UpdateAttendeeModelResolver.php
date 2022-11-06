<?php

declare(strict_types=1);

namespace App\ArgumentValueResolver;

use App\Domain\Model\UpdateAttendeeModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;

final class UpdateAttendeeModelResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return UpdateAttendeeModel::class === $argument->getType() && 'PUT' === $request->getMethod();
    }

    /**
     * @return iterable<UpdateAttendeeModel>
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield $this->serializer->deserialize(
            $request->getContent(),
            UpdateAttendeeModel::class,
            $request->getRequestFormat(),
        );
    }
}
