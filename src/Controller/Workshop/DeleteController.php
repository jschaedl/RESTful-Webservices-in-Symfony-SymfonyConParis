<?php

declare(strict_types=1);

namespace App\Controller\Workshop;

use App\Domain\WorkshopRemover;
use App\Entity\Workshop;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ADMIN')]
#[Route('/workshops/{identifier}', name: 'delete_workshop', methods: ['DELETE'])]
class DeleteController
{
    public function __construct(
        private WorkshopRemover $workshopRemover,
    ) {
    }

    public function __invoke(Request $request, Workshop $workshop)
    {
        $this->workshopRemover->remove($workshop);

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
