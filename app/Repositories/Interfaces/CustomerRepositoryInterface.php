<?php

namespace App\Repositories\Interfaces;

use App\Models\Customer\Customer;

interface CustomerRepositoryInterface
{
    public function find($id);

    public function findAll();

    public function save(Customer $customer);

}
