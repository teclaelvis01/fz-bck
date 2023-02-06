<?php

namespace App\Application\Portfolio;

use App\Entity\Allocations;
use App\Entity\OrderInterface;
use App\Entity\Orders;
use App\Exceptions\ExceededException;
use App\Repository\AllocationsRepository;
use App\Repository\OrdersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SellOrder implements OrderInterface{

    /**
     * 
     * @var AllocationsRepository
     */
    private $allocationRepository;
    /**
     * 
     * @param OrdersRepository $repository 
     * @param EntityManagerInterface $em 
     * @return void 
     */
    public function __construct(private OrdersRepository $repository,private EntityManagerInterface $em)
    {
      $this->allocationRepository = $em->getRepository(Allocations::class);
    }
    public function generate(Orders $order) { 
        // check if has locations
         $payload = $order->getPayload();
         $allocationId = $payload['allocation'];
         $share = $payload['shares'];

         $allocation = $this->allocationRepository->findOneBy(['id' => $allocationId]);
         if(!$allocation){
            throw new  NotFoundHttpException();
         }
         if($allocation->getShares()<$share){
            throw new ExceededException();
         }

        $this->repository->save($order,true);

    }

    

}