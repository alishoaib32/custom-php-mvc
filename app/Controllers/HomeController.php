<?php
namespace App\Controllers;

use App\Models\Order\Order as OrderModel;
use App\Models\Customer\Customer as CustomerModel;
use App\Repositories\OrderRepository;
use App\Repositories\CustomerRepository;

use \System\Controller as BaseController;
use App\Helpers;
use \System\View;

class HomeController extends BaseController
{
    private $orderRepository;
    private $customerRepository;

    /**
     * __construct function
     * dependency injection
    */
    public function __construct()
    {
        $this->orderRepository = new OrderRepository(new OrderModel());
        $this->customerRepository = new CustomerRepository(new CustomerModel());
    }

    /**
     * Index function
     * @param
     * @response render home view
    */

    public function indexAction()
    {

        View::render('home.php',['API_URL'=>API_URL]);
    }

    /**
     * not found function
     * @param
     * @response handled not found exception
     */

    public function  notFoundAction(){

        View::render('404_not_found.php',['message'=>"Oops, page not found!",'site_url'=>SITE_URL]);
        exit;
    }

}