<?php

namespace App\Application\Portfolio;

use App\Entity\OrderInterface;
use App\Entity\Orders;
use App\Repository\OrdersRepository;
use Doctrine\ORM\EntityManagerInterface;

class BuyOrder implements OrderInterface{

    public function __construct(private OrdersRepository $repository,private EntityManagerInterface $entityManager)
    {
        
    }
    public function generate(Orders $order) { 
        $this->repository->save($order,true);
    }


}