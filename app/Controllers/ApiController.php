<?php 

namespace App\Controllers;
use \System\Controller as BaseController;
use App\Models\Order\Order as OrderModel;
use App\Models\Customer\Customer as CustomerModel;
use App\Repositories\OrderRepository;
use App\Repositories\CustomerRepository;
use App\Helpers;

class ApiController extends BaseController
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
     * dashboard stats
     * @params start_date , end_date
     * @response Stats Object
     */
    public function dashboardStatsAction(){

        if(is_ajaxcall()) {

            $start_date = sanitizeDateInput(input()->get('start_date'));
            $end_date = sanitizeDateInput(input()->get('end_date'));
            if (empty($start_date) || empty($end_date)) {
                $this->response(false, 422, "Missing params");
            }

            $totalRevenue = 0;
            $totalCustomers = 0;
            $totalOrders = 0;

            // Get Order stats
            $fileters['start_date'] = $start_date . ' 00:00:00';
            $fileters['end_date'] = $end_date . ' 23:59:59';
            $fileters['group_by'] = 'DATE(o.purchase_date)';

            $fields = ['COUNT(*) as totalOrders , SUM(total_amount) as totalRevenue , Date(purchase_date) as purchase_date'];
            $OrderStats = $this->orderRepository->findByFilters($fields, $fileters);

            //Get Customer Stats
            $fileters['group_by'] = 'DATE(c.created_at)';
            $fields = ['COUNT(*) as totalCustomers , Date(created_at) as created_at'];
            $CustomerStats = $this->customerRepository->findByFilters($fields, $fileters);

            // Make ready response
            if (!empty($OrderStats) && count($OrderStats) > 0) {
                foreach ($OrderStats as $OrderStat):
                    $totalRevenue += $OrderStat['totalRevenue'];
                    $totalOrders += $OrderStat['totalOrders'];
                endforeach;
            }

            if (!empty($CustomerStats) && count($CustomerStats) > 0) {
                foreach ($CustomerStats as $CustomerStat):
                    $totalCustomers += $CustomerStat['totalCustomers'];
                endforeach;
            }

            $stats['totalRevenue'] = $totalRevenue;
            $stats['totalOrders'] = $totalOrders;
            $stats['totalCustomers'] = $totalCustomers;
            $stats['orderStats'] = $OrderStats;
            $stats['customerStats'] = $CustomerStats;

            $this->response(true, 200, "stats", $stats);
        }else{
            $this->response(true, 401, "Invalid request");
        }
    }


}