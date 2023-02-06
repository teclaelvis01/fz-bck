<?php

namespace App\Application\Portfolio;

use App\Entity\CompleteOrderInterface;
use App\Entity\Orders;
use App\Repository\OrdersRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PatchOrder{


    /**
     * 
     * @var array
     */
    private $casesApp = [
        Orders::TYPE_BUY => CompleteBuyOrder::class,
        Orders::TYPE_SELL => CompleteSellOrder::class,
    ];

    const STATUS_COMPLETE = 'completed';

    public function __construct(private OrdersRepository $ordersRepository,private EntityManagerInterface $em)
    {
        $this->ordersRepository = $ordersRepository;
    }

    public function patchOrder(Orders $order,Collection $collection){
        $status = $collection->get('status');
        
        if(!$status){
            throw new NotFoundHttpException('');
        }
        if($status != $this::STATUS_COMPLETE || $order->isCompleted()){
            return;
        }
        $order->setCompleted(true);
        
        /**
         * @var CompleteOrderInterface
         */
        $app = new $this->casesApp[$order->getType()]($this->ordersRepository, $this->em);
        $app->complete($order);
        $this->ordersRepository->save($order,true);
        
    }



}