<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $request = $event->getRequest();
        if(strpos($request->getPathInfo(),"/api/")!== 0){
            return;
        };

        if($event->getThrowable()->getCode() === 0){
            return;
        };

        $response = new JsonResponse(
            [
                "error" => $event->getThrowable()->getStatusCode(),
                "message" => $event->getThrowable()->getMessage(),
            ]
        );

        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}