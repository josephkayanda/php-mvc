<?php

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * load all classes to the index page
 */

/** auto load ubsent class **/
spl_autoload_register(function($classname){
    require $filename = "../app/models/".ucfirst($classname).".php";
});

require 'config.php';
require 'functions.php';
require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'App.php';