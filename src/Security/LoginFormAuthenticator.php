<?php

namespace App\Security;

use App\Entity\Compte;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CompteRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use App\Repository\TuteurRepository;
class LoginFormAuthenticator extends AbstractFormLoginAuthenticator implements PasswordAuthenticatedInterface
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private $compteRepository;
    private $urlGenerator;
    private $csrfTokenManager;
    private $passwordEncoder;
    private $security;
    private $tuteurRepository;

    public function __construct(CompteRepository $compteRepository,  UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder, Security $security,         TuteurRepository $tuteurRepository)
    {
        $this->compteRepository = $compteRepository;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->security= $security;
        $this->tuteurRepository = $tuteurRepository;

    }

    public function supports(Request $request)
    {
        return self::LOGIN_ROUTE === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        $user = $this->compteRepository->findOneBy(['email' => $credentials['email']]);
        $user->getEmail();
        $tuteur= $this->tuteurRepository->findOneByEmail($user->getEmail());

        if (!$user ) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Invalid credentials.');
        }
        if ($user->getTypeCompte()=='tuteur' and $tuteur->getValidation()=='0' ) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Vous n etes pas encore validé !');
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function getPassword($credentials): ?string
    {
        return $credentials['password'];
    }
    
    
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        $request->getSession()->getFlashBag()->add('success','Logged in succefully');
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }
        
        $user=$this->security->getUser();
        $user->getEmail();
        $tuteur= $this->tuteurRepository->findOneByEmail($user->getEmail());
        if($user->getTypeCompte()=='tuteur' and $tuteur->getValidation()=='1'){
            return new RedirectResponse($this->urlGenerator->generate('espace_parent'));
        }
        
        if($user->getTypeCompte()=='medcin'){
            return new RedirectResponse($this->urlGenerator->generate('espace_medcin'));
        }
        if($user->getTypeCompte()=='centre'){
            return new RedirectResponse($this->urlGenerator->generate('espace_centre'));
        }
    }

    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
