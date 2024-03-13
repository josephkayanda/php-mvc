<?php

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * Load all classes in the index page
 */

/** Autoload classes **/
spl_autoload_register(function($classname){
    $classname = explode("\\", $classname);
    $classname = end($classname);
    require $filename = "../app/models/".ucfirst($classname).".php";
});

/** Require necessary files **/
require 'config.php';       // Include configuration settings
require 'functions.php';    // Include common functions
require 'Database.php';     // Include the Database trait
require 'Model.php';        // Include the Model trait
require 'Controller.php';   // Include the Controller trait
require 'App.php';           // Include the App class
