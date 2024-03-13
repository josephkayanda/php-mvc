<?php

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * System configurations
 */

if ($_SERVER['SERVER_NAME'] == 'localhost') {
    
    /** Database config **/
    define('DBNAME', 'my_db');
    define('DBHOST', 'localhost');
    define('DBUSER', 'root');
    define('DBPASS', '');
    define('DBDRIVER', '');

    /** Root URL for localhost **/
    define('ROOT', 'http://localhost/mvc/public');

} else {
    
    /** Database config **/
    define('DBNAME', 'my_db');
    define('DBHOST', 'localhost');
    define('DBUSER', 'root');
    define('DBPASS', '');
    define('DBDRIVER', '');
      
    /** Root URL for production **/
    define('ROOT', 'https://www.yourwebsite.com');

}

/** Application information **/
define('APP_NAME', 'mymvc website');
define('APP_DESC', 'this is the best mvc website');

/** Debug mode setting **/
define('DEBUG', true); // true means show errors
