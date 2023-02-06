<?php

namespace App\Entity;

interface OrderInterface
{
    public function generate(Orders $order);
}
