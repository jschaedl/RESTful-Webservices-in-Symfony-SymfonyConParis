<?php

declare(strict_types=1);

namespace App\Security;

use App\Error\ApiError;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\InvalidTokenException;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class JwtTokenAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{
    private AuthorizationHeaderTokenExtractor $tokenExtractor;

    public function __construct(
        private JWTEncoderInterface $jwtEncoder,
        private SerializerInterface $serializer,
        private UserProviderInterface $userProvider
    ) {
        $this->tokenExtractor = new AuthorizationHeaderTokenExtractor(
            'Bearer',
            'Authorization'
        );
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        $error = new ApiError('Invalid credentials.', 'Authentication header required.');

        $serializedError = $this->serializer->serialize($error, $request->getRequestFormat());

        return new Response($serializedError, Response::HTTP_UNAUTHORIZED, [
            'WWW-Authenticate' => 'Bearer',
        ]);
    }

    public function supports(Request $request): ?bool
    {
        return false !== $this->tokenExtractor->extract($request);
    }

    public function authenticate(Request $request): Passport
    {
        $token = $this->tokenExtractor->extract($request);

        try {
            $data = $this->jwtEncoder->decode($token);
        } catch (JWTDecodeFailureException $decodeFailureException) {
            throw new InvalidTokenException('Invalid JWT Token', 0, $decodeFailureException);
        }

        return new SelfValidatingPassport(
            new UserBadge($data['username'], function ($userIdentifier) {
                return $this->userProvider->loadUserByIdentifier($userIdentifier);
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        $error = new ApiError('Invalid credentials.', 'Valid token required.');

        $serializedError = $this->serializer->serialize($error, $request->getRequestFormat());

        return new Response($serializedError, Response::HTTP_UNAUTHORIZED, [
            'WWW-Authenticate' => 'Bearer',
        ]);
    }
}
