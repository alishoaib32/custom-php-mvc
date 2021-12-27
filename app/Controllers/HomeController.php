<?php

namespace App\Controllers;

use \System\Controller as BaseController;
use App\Helpers;
use \System\View;

class HomeController extends BaseController
{

    /**
     * Index function
     * @param
     * @response render home view
     */

    public function indexAction()
    {

        View::render('home.php', ['API_URL' => API_URL]);
    }

    /**
     * not found function
     * @param
     * @response handled not found exception
     */

    public function notFoundAction()
    {

        View::render('404_not_found.php', ['message' => "Oops, page not found!", 'site_url' => SITE_URL]);
        exit;
    }

}