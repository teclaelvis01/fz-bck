<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

trait ResponseExceptionTrait
{

    function makeJsonResponseException(ExceptionEvent $event, int $code)
    {
        $response = new JsonResponse(null, $code);
        $event->setResponse($response);
    }
}
