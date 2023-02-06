<?php

namespace App\Application\Portfolio;

use App\Entity\Allocations;
use App\Entity\CompleteOrderInterface;
use App\Entity\Orders;
use App\Entity\Portfolios;
use App\Repository\AllocationsRepository;
use App\Repository\OrdersRepository;
use App\Repository\PortfoliosRepository;
use Doctrine\ORM\EntityManagerInterface;

class CompleteBuyOrder implements CompleteOrderInterface
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
            $allocation = new Allocations();
            $allocation->setShares($shares);
        } else {
            $allocationShares = $allocation->getShares() + $shares;
            $allocation->setShares($allocationShares);
        }

        $allocation->setPortfolios($portfolio);
        $this->portfoliosRepository->getManager()->persist($allocation);
        $this->portfoliosRepository->save($portfolio, true);
    }
}
