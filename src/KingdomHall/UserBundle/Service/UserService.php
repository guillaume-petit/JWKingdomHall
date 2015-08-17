<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 8/10/15
 * Time: 3:07 PM
 */

namespace KingdomHall\UserBundle\Service;

use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Util\TokenGenerator;
use KingdomHall\ServiceBundle\Service\MailService;
use KingdomHall\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Routing\Router;

class UserService
{
    /** @var MailService $mailer */
    protected $mailer;

    /** @var Translator $translator */
    protected $translator;

    /** @var Router $router */
    protected $router;

    /** @var TokenGenerator $tokenGenerator */
    protected $tokenGenerator;

    /** @var UserManager $userManager */
    protected $userManager;

    public function __construct(
        MailService $mailer,
        Translator $translator,
        Router $router,
        TokenGenerator $tokenGenerator,
        UserManager $userManager
    )
    {
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->router = $router;
        $this->tokenGenerator = $tokenGenerator;
        $this->userManager = $userManager;
    }

    public function sendWelcomeEmail(User $user)
    {
        $token = $this->tokenGenerator->generateToken();
        $link = $this->router->generate('fos_user_registration_register', array ('token' => $token), true);

        $this->mailer->sendMail(
            $this->translator->trans(
                'jwkh.publishers.email.welcome.subject',
                array(),
                null,
                $user->getPublisher()->getCongregation()->getDefaultLocale()
            ),
            'territory@jwkh.com',
            $user->getEmail(),
            $this->translator->trans(
                'jwkh.publishers.email.welcome.body',
                array('%link%' => $link),
                null,
                $user->getPublisher()->getCongregation()->getDefaultLocale()
            )
        );

        $user->setConfirmationToken($token);
        $this->userManager->updateUser($user);
    }

}