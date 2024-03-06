<?php

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * home controller
 */

class Home 
{
    use Controller;

    public function index()
    {

        $this->view('home');
    }

}




