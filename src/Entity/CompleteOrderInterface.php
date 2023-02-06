<?php

namespace App\Entity;

interface CompleteOrderInterface
{
    public function complete(Orders $order);
}
