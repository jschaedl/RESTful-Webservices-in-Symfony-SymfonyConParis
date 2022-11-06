<?php

declare(strict_types=1);

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/token', methods: ['POST'])]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class TokenController
{
    public function __construct(
        private JWTEncoderInterface $jwtEncoder,
        private SerializerInterface $serializer,
    ) {
    }

    public function __invoke(Request $request)
    {
        $token = $this->jwtEncoder->encode([
            'username' => $request->getUser(),
        ]);

        $data = ['token' => $token];

        $serializedData = $this->serializer->serialize($data, $request->getRequestFormat());

        return new Response($serializedData, Response::HTTP_OK);
    }
}
