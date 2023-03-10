<?php
declare(strict_types=1);

namespace App\Common\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Cookie\JWTCookieProvider;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AuthSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    /**
     * @var iterable|JWTCookieProvider[]
     */
    private array $cookieProviders;

    protected JWTTokenManagerInterface $jwtManager;

    protected EventDispatcherInterface $dispatcher;

    /**
     * @param iterable|JWTCookieProvider[] $cookieProviders
     */
    public function __construct(
        JWTTokenManagerInterface $jwtManager,
        EventDispatcherInterface $dispatcher,
        ?array                   $cookieProviders = null
    )
    {
        $this->jwtManager = $jwtManager;
        $this->dispatcher = $dispatcher;
        $this->cookieProviders = (array)$cookieProviders;
    }

    public function handleAuthenticationSuccess(UserInterface $user, $jwt = null): JWTAuthenticationSuccessResponse
    {
//        You can check if the user has not confirmed the email
//        For example:
//        if ($user->isEmailConfirmed() === false) {
//            return new JsonResponse(
//                ['error' => 'You cannot be authorized until you receive confirmation by mail.'],
//                Response::HTTP_UNAUTHORIZED
//            );
//        }

        if ($jwt === null) {
            $jwt = $this->jwtManager->create($user);
        }

        $jwtCookies = [];
        foreach ($this->cookieProviders as $cookieProvider) {
            $jwtCookies[] = $cookieProvider->createCookie($jwt);
        }

        $response = new JWTAuthenticationSuccessResponse($jwt, [], $jwtCookies);
        $event = new AuthenticationSuccessEvent(['token' => $jwt], $user, $response);

        $this->dispatcher->dispatch($event, Events::AUTHENTICATION_SUCCESS);
        $responseData = $event->getData();

        if ($jwtCookies) {
            unset($responseData['token']);
        }

        if ($responseData) {
            $response->setData($responseData);
        } else {
            $response->setStatusCode(Response::HTTP_NO_CONTENT);
        }

        return $response;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): Response
    {
        return $this->handleAuthenticationSuccess($token->getUser());
    }
}