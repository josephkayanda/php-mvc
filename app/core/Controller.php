<?php

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * Main controller
 */
trait MainController
{
    /**
     * Render a view by including the corresponding PHP file
     * @param string $name The name of the view file (without the '.view.php' extension)
     */
    public function view($name)
    {
        // Construct the file path for the view
        $filename = "../app/views/".$name.".view.php";

        // Check if the view file exists
        if (file_exists($filename)) {
            // If the view file exists, include it
            require $filename;
        } else {
            // If the view file doesn't exist, include a default 404 view
            $filename = "../app/views/404.view.php";
            require $filename;
        }
    }
}
