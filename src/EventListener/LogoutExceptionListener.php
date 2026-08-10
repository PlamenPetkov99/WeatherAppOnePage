<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\LogoutException;

#[AsEventListener(event: KernelEvents::EXCEPTION, priority: 0)]
class LogoutExceptionListener
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();
        while (null !== $throwable && !$throwable instanceof LogoutException) {
            $throwable = $throwable->getPrevious();
        }

        if (!$throwable instanceof LogoutException) {
            return;
        }

        $event->getRequest()->getSession()->getFlashBag()->add('error', 'You are already logged out.');
        $event->setResponse(new RedirectResponse($this->urlGenerator->generate('app_login')));
    }
}
