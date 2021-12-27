<?php

namespace App\Models\Order;

use \System\Model as BaseModel;

class Order extends BaseModel
{

    public $table = 'orders';

    public $id;
    public $customer_id;
    public $total_amount;
    public $country_id;
    public $device;
    public $purchase_date;

}