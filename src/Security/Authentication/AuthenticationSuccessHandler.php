<?php

namespace App\Security\Authentication;

use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
  public function onAuthenticationSuccess(Request $request, TokenInterface $token): JsonResponse
  {
    /** @var User */
    $user = $token->getUser();
    $userApiToken = $user->getApiTokens()->first();

    return new JsonResponse(['apiToken' => $userApiToken]);
  }
}
