<?php

namespace AWurth\SilexUser\EventListener;

use AWurth\SilexUser\Event\Events;
use AWurth\SilexUser\Event\FilterUserResponseEvent;
use AWurth\SilexUser\Event\UserEvent;
use AWurth\SilexUser\Security\LoginManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\AccountStatusException;

class AuthenticationListener implements EventSubscriberInterface
{
    /**
     * @var LoginManager
     */
    protected $loginManager;

    /**
     * @var string
     */
    protected $firewallName;

    /**
     * Constructor.
     *
     * @param LoginManager $loginManager
     * @param string       $firewallName
     */
    public function __construct(LoginManager $loginManager, $firewallName)
    {
        $this->loginManager = $loginManager;
        $this->firewallName = $firewallName;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::REGISTRATION_COMPLETED => 'authenticate',
            Events::REGISTRATION_CONFIRMED => 'authenticate'
        ];
    }

    /**
     * Authenticates the user.
     *
     * @param FilterUserResponseEvent $event
     * @param EventDispatcherInterface $dispatcher
     */
    public function authenticate(FilterUserResponseEvent $event, EventDispatcherInterface $dispatcher)
    {
        try {
            $this->loginManager->logInUser($this->firewallName, $event->getUser(), $event->getResponse());

            $dispatcher->dispatch(Events::SECURITY_IMPLICIT_LOGIN, new UserEvent($event->getUser(), $event->getRequest()));
        } catch (AccountStatusException $e) {
            // We simply do not authenticate users which do not pass the user
            // checker (not enabled, expired, etc.).
        }
    }
}
