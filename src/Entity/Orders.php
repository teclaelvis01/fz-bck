<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{

    const TYPE_BUY = "buy";
    const TYPE_SELL = "sell";

    #[ORM\Id]
    #[ORM\GeneratedValue('NONE')]
    #[ORM\Column]
    #[Groups('orders')]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[Groups('portfolio_detail')]
    private ?Portfolios $portfolio = null;


    #[ORM\Column(length: 5)]
    // #[Assert\Choice(choices:[self::TYPE_BUY,self::TYPE_SELL])]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?bool $completed = null;

    #[ORM\Column]
    private array $payload = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $value): self
    {
        $this->id = $value;
        return $this;
    }

    public function getPortfolio(): ?Portfolios
    {
        return $this->portfolio;
    }

    public function setPortfolio(?Portfolios $portfolio): self
    {
        $this->portfolio = $portfolio;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function isCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(?bool $completed): self
    {
        $this->completed = $completed;

        return $this;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function setPayload(array $payload): self
    {
        $this->payload = $payload;

        return $this;
    }
}
