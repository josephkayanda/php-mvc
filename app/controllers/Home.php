<?php

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * Home controller
 */

class Home 
{
    use MainController;

    public function index()
    {

        $this->view('home');
    }

}




