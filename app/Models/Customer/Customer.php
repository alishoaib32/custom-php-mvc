<?php

namespace App\Models\Customer;

use \System\Model as BaseModel;

class Customer extends BaseModel
{

    public $table = 'customers';

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $created_at;
    public $updated_at;

}