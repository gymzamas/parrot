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

class LoginAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    /**
     * Authentifie un utilisateur en fonction de ses informations de connexion.
     *
     * @param Request $request
     * @return Passport
     */
    public function authenticate(Request $request): Passport
    {
        // Récupérer l'email et le mot de passe du formulaire
        $email = $request->get('email');
        $password = $request->get('password');
        $csrfToken = $request->get('_csrf_token');

        // Enregistrer le dernier email utilisé pour la connexion
        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email);

        // Retourner un Passport avec les badges nécessaires
        return new Passport(
            new UserBadge($email), // Utilisateur basé sur l'email
            new PasswordCredentials($password), // Mot de passe pour l'authentification
            [
                new CsrfTokenBadge('authenticate', $csrfToken), // Validation CSRF
                new RememberMeBadge(), // Gérer "Remember Me" si activé
            ]
        );
    }

    /**
     * Définir la redirection après une authentification réussie.
     *
     * @param Request $request
     * @param TokenInterface $token
     * @param string $firewallName
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Si un chemin cible est défini (l'utilisateur revient d'une page protégée), rediriger vers cette page
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // Sinon, rediriger vers la page d'accueil ou autre route par défaut
        return new RedirectResponse($this->urlGenerator->generate('home')); // Exemple avec la route 'home'
    }

    /**
     * Récupérer l'URL de connexion en cas de redirection depuis une page protégée.
     *
     * @param Request $request
     * @return string
     */
    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
