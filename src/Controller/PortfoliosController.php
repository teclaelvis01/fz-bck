<?php

namespace App\Controller;

use App\Application\Portfolio\UpdatePortfolio;
use App\Entity\Allocations;
use App\Entity\ModelFactory;
use App\Entity\Orders;
use App\Entity\Portfolios;
use App\Traits\ResponseExceptionTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Annotation\Route;

class PortfoliosController extends AbstractController implements EventSubscriberInterface
{

    use ResponseExceptionTrait;

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof NotFoundHttpException) {
            $this->makeJsonResponseException($event, Response::HTTP_NOT_FOUND);
        }
        return;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    #[Route('/api/portfolios/{id}', name: 'get_portfolio', methods: ['GET'],)]
    public function getAction(Portfolios $entity,SerializerInterface $serializer): JsonResponse
    {
        $data = $serializer->serialize($entity, 'json', [
            'groups' => ['portfolio','allocation']
        ]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
    #[Route('/api/portfolios/{id}', name: 'put_portfolio', methods: ['PUT'],)]
    public function putAction(Request $request, Portfolios $entity, UpdatePortfolio $orderUpdate): JsonResponse
    {
        
        $data = new ArrayCollection($request->toArray());

        /** @var Allocations[] */
        $allocations = ModelFactory::createArray(Allocations::class,$data->get('allocations'));
        $orderUpdate->updateOrder($entity,$allocations);

        return $this->json(null, Response::HTTP_OK);
    }
}
