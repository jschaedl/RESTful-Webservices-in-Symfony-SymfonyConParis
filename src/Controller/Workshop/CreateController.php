<?php

declare(strict_types=1);

namespace App\Controller\Workshop;

use App\Domain\Model\CreateWorkshopModel;
use App\Domain\WorkshopCreator;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[IsGranted('ROLE_USER')]
#[Route('/workshops', name: 'create_workshop', methods: ['POST'])]
final class CreateController
{
    public function __construct(
        private WorkshopCreator $workshopCreator,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    /**
     * @OA\Post(
     *     tags={"Workshop"},
     *     summary="Creates a workshop.",
     *     description="Creates a workshop.",
     *     @OA\RequestBody(
     *          @Model(type=CreateWorkshopModel::class)
     *     ),
     *     @OA\Response(
     *          description="Returns the created workshop.",
     *          response=201
     *     )
     * )
     */
    public function __invoke(Request $request, CreateWorkshopModel $createWorkshopModel)
    {
        $createdWorkshop = $this->workshopCreator->create($createWorkshopModel);

        $serializedCreatedWorkshop = $this->serializer->serialize($createdWorkshop, $request->getRequestFormat());

        return new Response($serializedCreatedWorkshop, Response::HTTP_CREATED, [
            'Location' => $this->urlGenerator->generate('read_workshop', [
                'identifier' => $createdWorkshop->getIdentifier(),
            ], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
    }
}
