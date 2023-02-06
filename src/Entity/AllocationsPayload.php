<?php

namespace App\Entity;

class AllocationsPayload
{
    
    private int $id;
    private int $shares;

    public function __construct()
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $value): self
    {
        $this->id = $value;
        return $this;
    }

    public function getShares():int
    {
        return $this->shares;
    }

    public function setShares(int $shares): self
    {
        $this->shares = $shares;

        return $this;
    }
}
