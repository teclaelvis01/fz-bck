<?php

namespace App\Entity;

use App\Repository\AllocationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: AllocationsRepository::class)]
class Allocations
{
    #[ORM\Id]
    #[ORM\GeneratedValue('NONE')]
    #[ORM\Column]
    #[Groups('allocation')]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups('allocation')]
    private ?int $shares = null;

    #[ORM\ManyToOne(inversedBy: 'allocations')]
    #[Groups('portfolio_detail')]
    #[MaxDepth(1)]
    private ?Portfolios $portfolios = null;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $value): self
    {
        $this->id = $value;
        return $this;
    }

    public function getShares(): ?int
    {
        return $this->shares;
    }

    public function setShares(int $shares): self
    {
        $this->shares = $shares;

        return $this;
    }

    public function getPortfolios(): ?Portfolios
    {
        return $this->portfolios;
    }

    public function setPortfolios(?Portfolios $portfolios): self
    {
        $this->portfolios = $portfolios;

        return $this;
    }


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'shares' => $this->shares,
        ];
    }
}
