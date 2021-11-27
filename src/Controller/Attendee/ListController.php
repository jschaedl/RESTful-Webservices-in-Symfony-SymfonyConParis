<?php

declare(strict_types=1);

namespace App\Controller\Attendee;

use App\Pagination\AttendeeCollectionFactory;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/attendees', name: 'list_attendee', methods: ['GET'])]
final class ListController
{
    public function __construct(
        private AttendeeCollectionFactory $attendeeCollectionFactory,
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * @OA\Get(
     *      tags={"Attendee"},
     *      summary="Returns a paginated collection of attendees.",
     *      description="Returns a paginated collection of attendees.",
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
        $attendeeCollection = $this->attendeeCollectionFactory->create(
            $request->query->getInt('page', 1),
            $request->query->getInt('size', 10)
        );

        $serializedAttendeeCollection = $this->serializer->serialize(
            $attendeeCollection,
            $request->getRequestFormat()
        );

        return new Response($serializedAttendeeCollection, Response::HTTP_OK);
    }
}
