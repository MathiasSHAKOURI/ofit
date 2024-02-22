<?php

namespace App\EventSubscriber;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginSubscriber implements EventSubscriberInterface
{
    private $router;
    private $redirect = false;
    private $flash;

    public function __construct(RouterInterface $router, FlashBagInterface $flash)
    {
        $this->router = $router;
        $this->flash = $flash;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event): void
    {
        $request = $event->getRequest();
        $user = $event->getAuthenticationToken()->getUser();

        if ($request->getPathInfo() === '/admin/login' && in_array('ROLE_USER', $user->getRoles())) {
            $event->getAuthenticationToken()->setAuthenticated(false);
            $this->flash->add(
                'warning', 'Vous n\'êtes pas autorisé à vous connecter depuis cette interface.'
            );
            $this->redirect = true;
        };

        if ($request->getPathInfo() === '/user/login' && in_array('ROLE_ADMIN', $user->getRoles())) {
            $event->getAuthenticationToken()->setAuthenticated(false);
            $this->flash->add(
                'warning', 'Vous n\'êtes pas autorisé à vous connecter depuis cette interface.'
            );
            $this->redirect = 1;
        };
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        if ($this->redirect) {
            $response = new RedirectResponse($this->router->generate('app_back_login'));
            $event->setResponse($response);
        };

        if ($this->redirect === 1) {
            $response = new RedirectResponse($this->router->generate('app_front_login'));
            $event->setResponse($response);
        };
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'security.interactive_login' => 'onSecurityInteractiveLogin',
            'kernel.response' => 'onKernelResponse',
        ];
    }
}
