<?php

namespace App\EventSubscriber;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;

class IsVerifiedSubscriber implements EventSubscriberInterface
{
    private $router;
    private $redirect = false;
    private $flash;

    public function __construct(RouterInterface $router, FlashBagInterface $flash)
    {
        $this->router = $router;
        $this->flash = $flash;
    }

    public function onSecurityAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        $user = $event->getAuthenticationToken()->getUser();

        if ($user->isVerified() === false)
        {
            $event->getAuthenticationToken()->setAuthenticated(false);
            $this->flash->add(
                'warning', 'Vous n\'avez pas validé votre compte. Merci de vérifier vos email.'
            );
            $this->redirect = true;
        };
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        if ($this->redirect) {
            $response = new RedirectResponse($this->router->generate('app_front_login'));
            $event->setResponse($response);
        };
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'security.authentication.success' => 'onSecurityAuthenticationSuccess',
            'kernel.response' => 'onKernelResponse',
        ];
    }
}
