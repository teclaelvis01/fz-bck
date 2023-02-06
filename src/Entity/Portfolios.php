<?php

namespace App\Entity;

use App\Repository\PortfoliosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: PortfoliosRepository::class)]
class Portfolios
{
    #[ORM\Id]
    #[ORM\GeneratedValue('NONE')]
    #[ORM\Column]
    #[Groups('portfolio')]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'portfolios', targetEntity: Allocations::class)]
    #[Groups('portfolio')]
    #[MaxDepth(1)]
    private Collection $allocations;

    #[ORM\OneToMany(mappedBy: 'portfolio', targetEntity: Orders::class)]
    #[MaxDepth(1)]
    private Collection $orders;


    public function __construct()
    {
        $this->allocations = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function setId(int $value): self
    {
        $this->id = $value;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Allocations>
     */
    public function getAllocations(): Collection
    {
        return $this->allocations;
    }

    public function addAllocation(Allocations $allocation): self
    {
        if (!$this->allocations->contains($allocation)) {
            $this->allocations->add($allocation);
            $allocation->setPortfolios($this);
        }

        return $this;
    }

    public function removeAllocation(Allocations $allocation): self
    {
        if ($this->allocations->removeElement($allocation)) {
            // set the owning side to null (unless already changed)
            if ($allocation->getPortfolios() === $this) {
                $allocation->setPortfolios(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Orders>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setPortfolio($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getPortfolio() === $this) {
                $order->setPortfolio(null);
            }
        }

        return $this;
    }

}
