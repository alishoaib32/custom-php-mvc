<?php

namespace system;

use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Base controller
 */
abstract class Controller
{

    /**
     *  This Magic method called when a non-existent method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     */
    public function __call($name, $args)
    {
        $method = explode("Action", $name)[0];
        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before()
    {

    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after()
    {

    }

    /**
     * Response function
     * @Params status:boolean , status_code:int , message:string , data:[]
     * @response  JSON Object
    */
    public function response($status = true, $status_code = 200, $message = "", $data = [])
    {
        $response = ["status" => $status, "status_code" => $status_code, "message" => $message, "data" => $data];
        echo json_encode($response);
        exit;
    }
}