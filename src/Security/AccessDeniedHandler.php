<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

/**
 * Handles access denial in the application by redirecting unauthorized users
 * to the login page or another appropriate route.
 */
class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
  private RouterInterface $router;

  /**
   * Constructor for AccessDeniedHandler.
   *
   * @param RouterInterface $router The router interface to generate routes.
   */
  public function __construct(RouterInterface $router)
  {
    $this->router = $router;
  }

  /**
   * Handles AccessDeniedException by redirecting to a login page or custom route.
   *
   * @param Request $request The current request object.
   * @param AccessDeniedException $accessDeniedException The exception thrown due to access denial.
   * @return RedirectResponse Redirects the user to the login page with a custom accessDenied parameter.
   */
  public function handle(Request $request, AccessDeniedException $accessDeniedException): RedirectResponse
  {
    return new RedirectResponse($this->router->generate('app_login', ['accessDenied' => true]));
  }
}
