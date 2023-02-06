<?php

namespace App\DataFixtures;

use App\Entity\Allocations;
use App\Entity\Portfolios;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PortfolioFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $portfolio = new Portfolios();
        $portfolio->setId(1);
        $manager->persist($portfolio);
        
        // $allocation1 = new Allocations();
        // $allocation1->setId(1);
        // $allocation1->setShares(3);
        // $allocation1->setPortfolios($portfolio);
        // $manager->persist($allocation1);

        // $allocation1 = new Allocations();
        // $allocation1->setId(2);
        // $allocation1->setShares(4);
        // $allocation1->setPortfolios($portfolio);
        // $manager->persist($allocation1);


        $manager->flush();
    }
}
