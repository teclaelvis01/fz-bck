<?php

namespace App\Application\Portfolio;

use App\Entity\Allocations;
use App\Entity\Orders;
use App\Entity\Portfolios;
use App\Repository\PortfoliosRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;



class UpdatePortfolio
{

    /**
     * 
     * @var Collection
     */
    private $constraints;

    public function __construct(private PortfoliosRepository $portfoliosRepository,private ValidatorInterface $validator)
    {
        $this->constraints = new Assert\Collection([
            'id' => [
                new Assert\NotBlank(),
                new Assert\Type('integer')
            ],
            'shares' => [
                new Assert\NotBlank(),
                new Assert\Type('integer')
            ]
        ]);
    }

    /**
     * 
     * @param Portfolios $portfolio 
     * @param Allocations[] $allocations 
     * @return void 
     */
    public function updateOrder(Portfolios $portfolio, array $allocations)
    {
        
        
        $this->portfoliosRepository->removeAllOrders($portfolio,true);
        $this->portfoliosRepository->removeAllocations($portfolio,true);
        foreach ($allocations as $item) {
            $errors = $this->validator->validate($item->toArray(), $this->constraints);
            if (count($errors) > 0) {
                throw new BadRequestHttpException('');
            }
            $item->setPortfolios($portfolio);
            $this->portfoliosRepository->getManager()->persist($item);
        }
        $this->portfoliosRepository->save($portfolio, true);
    }
}
