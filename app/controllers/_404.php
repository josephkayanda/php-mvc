<?php

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * 404 controller not found 
 */

class _404
{
    use Controller;
    public function index()
    {
        echo "404 page not found controller";
    }
}

