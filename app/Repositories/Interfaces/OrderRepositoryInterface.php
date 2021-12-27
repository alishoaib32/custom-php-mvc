<?php

namespace App\Repositories\Interfaces;

use App\Models\Order\Order;

interface OrderRepositoryInterface
{
    public function find($id);

    public function findAll();

    public function save(Order $order);

}
