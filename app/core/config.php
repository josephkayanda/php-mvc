<?php

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * system configurations
 */

if ($_SERVER['SERVER_NAME'] == 'localhost') {
    
    /** database config **/
    define('DBNAME', 'my_db');
    define('DBHOST', 'localhost');
    define('DBUSER', 'root');
    define('DBPASS', '');
    define('DBDRIVER', '');

    define('ROOT', 'http://localhost/mvc/public');

} else {
    
    /** database config **/
    define('DBNAME', 'my_db');
    define('DBHOST', 'localhost');
    define('DBUSER', 'root');
    define('DBPASS', '');
    define('DBDRIVER', '');
      
    define('ROOT', 'https://www.yourwebsite.com');

}

define('APP_NAME', 'mymvc website');
define('APP_DESC', 'this is the best mvc website');
define('DEBUG', true); //true means show errors
