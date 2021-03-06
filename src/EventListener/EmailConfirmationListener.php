<?php

/*
 * This file is part of the awurth/silex-user package.
 *
 * (c) Alexis Wurth <awurth.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AWurth\Silex\User\EventListener;

use AWurth\Silex\User\Model\UserInterface;
use AWurth\Silex\User\Event\Events;
use AWurth\Silex\User\Event\FormEvent;
use AWurth\Silex\User\Mailer\MailerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EmailConfirmationListener implements EventSubscriberInterface
{
    /**
     * @var MailerInterface
     */
    protected $mailer;

    /**
     * @var UrlGeneratorInterface
     */
    protected $router;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * Constructor.
     *
     * @param MailerInterface       $mailer
     * @param UrlGeneratorInterface $router
     * @param SessionInterface      $session
     */
    public function __construct(MailerInterface $mailer, UrlGeneratorInterface $router, SessionInterface $session)
    {
        $this->mailer = $mailer;
        $this->router = $router;
        $this->session = $session;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::REGISTRATION_SUCCESS => 'sendConfirmationEmail'
        ];
    }

    /**
     * Sends an email to the user to activate his account.
     *
     * @param FormEvent $event
     */
    public function sendConfirmationEmail(FormEvent $event)
    {
        /** @var UserInterface $user */
        $user = $event->getForm()->getData();

        $user->setEnabled(false);
        if (null === $user->getConfirmationToken()) {
            $user->setConfirmationToken($this->generateToken());
        }

        $this->mailer->sendConfirmationEmailMessage($user);

        $this->session->set('silex_user_confirmation_email', $user->getEmail());

        $event->setResponse(new RedirectResponse($this->router->generate('silex_user.registration_check_email')));
    }

    /**
     * Generates a new confirmation token.
     *
     * @return string
     */
    protected function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}
