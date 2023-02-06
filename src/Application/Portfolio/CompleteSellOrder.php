<?php

namespace App\Application\Portfolio;

use App\Entity\Allocations;
use App\Entity\CompleteOrderInterface;
use App\Entity\Orders;
use App\Entity\Portfolios;
use App\Repository\AllocationsRepository;
use App\Repository\OrdersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompleteSellOrder implements CompleteOrderInterface
{

  /**
   * 
   * @var AllocationsRepository
   */
  private $allocationRepository;

  /**
   * 
   * @var PortfoliosRepository
   */
  private $portfoliosRepository;
  /**
   * 
   * @param OrdersRepository $repository 
   * @param EntityManagerInterface $em 
   * @return void 
   */
  public function __construct(private OrdersRepository $repository, private EntityManagerInterface $em)
  {
    $this->allocationRepository = $em->getRepository(Allocations::class);
    $this->portfoliosRepository = $em->getRepository(Portfolios::class);
  }

  public function complete(Orders $order)
  {
    $payload = $order->getPayload();
    $portfolio = $order->getPortfolio();
    $shares = $payload['shares'];

    $allocation = $this->allocationRepository->findOneBy(['id' => $payload['allocation']]);
    if (!$allocation) {
      throw new NotFoundHttpException('');
    }
    $allocationShares = $allocation->getShares() - $shares;
    if($allocationShares == 0){
      $this->allocationRepository->remove($allocation,true);
    }else{
      $allocation->setShares($allocationShares);
      $this->portfoliosRepository->getManager()->persist($allocation);
    }

    $this->portfoliosRepository->save($portfolio, true);
  }
}
