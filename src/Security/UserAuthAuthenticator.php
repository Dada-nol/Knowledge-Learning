<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;


/**
 * UserAuthAuthenticator is responsible for authenticating users during the login process.
 * It extends the AbstractLoginFormAuthenticator and provides logic for handling login form authentication.
 */
class UserAuthAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    /**
     * Constructor for injecting the UrlGeneratorInterface.
     *
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(private UrlGeneratorInterface $urlGenerator) {}

    /**
     * This method is responsible for creating and returning a Passport object which holds user credentials.
     * The Passport object is used by Symfony's security system for authenticating the user.
     *
     * @param Request $request The HTTP request containing login information (email, password, csrf token).
     * @return Passport The Passport object containing user credentials and security badges (CSRF, RememberMe).
     */
    public function authenticate(Request $request): Passport
    {
        $email = $request->getPayload()->getString('email');

        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->getPayload()->getString('password')),
            [
                new CsrfTokenBadge('authenticate', $request->getPayload()->getString('_csrf_token')),
                new RememberMeBadge(),
            ]
        );
    }

    /**
     * Handles actions on successful authentication. If a target path is available (stored previously), the user is
     * redirected to that path, otherwise, they are redirected to the homepage.
     *
     * @param Request $request The HTTP request object.
     * @param TokenInterface $token The security token for the authenticated user.
     * @param string $firewallName The name of the firewall used for this authentication process.
     * @return Response|null The response object for redirection.
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('app_home'));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
