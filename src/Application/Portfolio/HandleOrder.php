<?php

namespace App\Application\Portfolio;

use App\Entity\OrderInterface;
use App\Entity\Orders;
use App\Repository\AllocationsRepository;
use App\Repository\OrdersRepository;
use App\Repository\PortfoliosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\HttpFoundation\Response;

class HandleOrder
{


    /**
     * 
     * @var Collection
     */
    private $constraints;

    /**
     * 
     * @var array
     */
    private $casesApp = [
        Orders::TYPE_BUY => BuyOrder::class,
        Orders::TYPE_SELL => SellOrder::class,
    ];

    public function __construct(private OrdersRepository $ordersRepository, private ValidatorInterface $validator, private  AllocationsRepository $allocationsRepository, private PortfoliosRepository $portfoliosRepository, private EntityManagerInterface $em)
    {
        $this->constraints = new Assert\Collection([
            'id' => [
                new Assert\NotBlank(),
                new Assert\Type('integer')
            ],
            'shares' => [
                new Assert\NotBlank(),
                new Assert\Type('integer')
            ],
            'type' => [
                new Assert\NotBlank(),
                new Assert\Choice(['choices' => [Orders::TYPE_BUY, Orders::TYPE_SELL]])
            ],
            'portfolio' => [
                new Assert\NotBlank(),
                new Assert\Type('integer')
            ],
            'allocation' => [
                new Assert\NotBlank(),
                new Assert\Type('integer')
            ],
        ]);
    }

    public function handle(Request $request): int
    {
        $body = $request->toArray();
        $errors = $this->validator->validate($body, $this->constraints);
        if (count($errors) > 0) {
            throw new BadRequestHttpException('');
        }

        // validate portfolio
        $portfolio = $this->portfoliosRepository->findOneBy(['id' => $body['portfolio']]);
        if (!$portfolio) {
            throw new NotFoundHttpException('');
        }

        /** @var Orders */
        $order = new Orders();
        $order->setId($body['id']);
        $order->setType($body['type']);
        $order->setPortfolio($portfolio);
        $payload = [
            'allocation' => $body['allocation'],
            'shares' => $body['shares'],
        ];
        $order->setPayload($payload);
        $order->setCompleted(false);
        /**
         * @var OrderInterface
         */
        $app = new $this->casesApp[$body['type']]($this->ordersRepository, $this->em);
        $app->generate($order);
        return $body['type'] == Orders::TYPE_BUY ? Response::HTTP_CREATED : Response::HTTP_OK;
    }
}
