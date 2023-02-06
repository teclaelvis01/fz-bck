<?php

namespace App\Controller;

use App\Application\Portfolio\HandleOrder;
use App\Application\Portfolio\PatchOrder;
use App\Entity\Orders;
use App\Exceptions\ExceededException;
use App\Traits\ResponseExceptionTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Annotation\Route;

class OrdersController extends AbstractController implements EventSubscriberInterface
{
    use ResponseExceptionTrait;

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof NotFoundHttpException) {
            $this->makeJsonResponseException($event, Response::HTTP_NOT_FOUND);
        }
        if ($exception instanceof BadRequestHttpException) {
            $this->makeJsonResponseException($event, Response::HTTP_BAD_REQUEST);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            $this->makeJsonResponseException($event, Response::HTTP_METHOD_NOT_ALLOWED);
        }
        if ($exception instanceof ExceededException) {
            $this->makeJsonResponseException($event, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    #[Route('/api/orders', name: 'new_order', methods: ['POST'],)]
    public function postAction(Request $request, HandleOrder $orderHandle): JsonResponse
    {
        $resultCode = $orderHandle->handle($request);
        return $this->json(null, $resultCode);
    }

    #[Route('/api/orders/{id}', name: 'patch_order', methods: ['PATCH'],)]
    public function patchAction(Orders $entity,Request $request, PatchOrder $patchOrder): JsonResponse
    {
        
        $patchOrder->patchOrder($entity,new ArrayCollection($request->toArray()));
        return $this->json(null, Response::HTTP_OK);
    }
    
}
