<?php

declare(strict_types=1);

namespace App\Controller\Workshop;

use App\Pagination\WorkshopCollectionFactory;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/workshops', name: 'list_workshop', methods: ['GET'])]
final class ListController
{
    public function __construct(
        private WorkshopCollectionFactory $workshopCollectionFactory,
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * @OA\Get(
     *      tags={"Workshop"},
     *      summary="Returns a paginated collection of workshops.",
     *      description="Returns a paginated collection of workshops.",
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="The field to specify the current page.",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name="size",
     *          in="query",
     *          description="The field to specify the current page size.",
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(
     *          description="Returns a list of attendees.",
     *          response=200,
     *          content={
     *              @OA\MediaType(mediaType="application/json"),
     *              @OA\MediaType(mediaType="application/hal+json"),
     *              @OA\MediaType(mediaType="text/xml")
     *          }
     *      )
     * )
     */
    public function __invoke(Request $request): Response
    {
        $workshopCollection = $this->workshopCollectionFactory->create(
            $request->query->getInt('page', 1),
            $request->query->getInt('size', 10)
        );

        $serializedWorkshopCollection = $this->serializer->serialize(
            $workshopCollection,
            $request->getRequestFormat()
        );

        return new Response($serializedWorkshopCollection, Response::HTTP_OK);
    }
}
