<?php

/**
 * Request class
 * Gets and sets data in the POST and GET global variables
 */

namespace Core;

defined('ROOTPATH') OR exit('Access Denied!');

class Request
{
	
	 /**
	 * Check which HTTP method was used in the current request
	 * @return string Returns the HTTP method (e.g., 'GET', 'POST', 'PUT', 'DELETE')
	 */
	public function method(): string
	{
	    return $_SERVER['REQUEST_METHOD'];
	}

	 
	 /**
	 * Check if something was posted in the current request
	 * @return bool Returns true if the request method is POST and there is posted data, otherwise returns false
	 */
	public function posted(): bool
	{
	    if ($_SERVER['REQUEST_METHOD'] == "POST" && count($_POST) > 0) {
	        return true;
	    }

	    return false;
	}

	
	/**
	 * Get a value from the POST variable
	 *
	 * @param string $key     The key to retrieve from the $_POST variable
	 * @param mixed  $default The default value to return if the key is not found in $_POST (default is an empty string)
	 * @return mixed Returns the value associated with the key in $_POST if found, otherwise returns the default value or the entire $_POST array if no key is specified
	 */
	public function post(string $key = '', mixed $default = ''): mixed
	{
	    if (empty($key)) {
	        // If no key is specified, return the entire $_POST array
	        return $_POST;
	    } else if (isset($_POST[$key])) {
	        // If the key exists in $_POST, return the corresponding value
	        return $_POST[$key];
	    }

	    // If the key is not found in $_POST, return the default value
	    return $default;
	}
	
	/**
	 * Get a value from the FILES variable
	 * @param string $key     The key to retrieve from the $_FILES variable
	 * @param mixed  $default The default value to return if the key is not found in $_FILES (default is an empty string)
	 * @return mixed Returns the value associated with the key in $_FILES if found, otherwise returns the default value or the entire $_FILES array if no key is specified
	 */
	public function files(string $key = '', mixed $default = ''): mixed
	{
	    if (empty($key)) {
	        // If no key is specified, return the entire $_FILES array
	        return $_FILES;
	    } else if (isset($_FILES[$key])) {
	        // If the key exists in $_FILES, return the corresponding value
	        return $_FILES[$key];
	    }

	    // If the key is not found in $_FILES, return the default value
	    return $default;
	}

	/**
	 * Get a value from the GET variable
	 * @param string $key     The key to retrieve from the $_GET variable
	 * @param mixed  $default The default value to return if the key is not found in $_GET (default is an empty string)
	 * @return mixed Returns the value associated with the key in $_GET if found, otherwise returns the default value or the entire $_GET array if no key is specified
	 */
	public function get(string $key = '', mixed $default = ''): mixed
	{
	    if (empty($key)) {
	        // If no key is specified, return the entire $_GET array
	        return $_GET;
	    } else if (isset($_GET[$key])) {
	        // If the key exists in $_GET, return the corresponding value
	        return $_GET[$key];
	    }

	    // If the key is not found in $_GET, return the default value
	    return $default;
	}


	/**
	 * Get a value from the REQUEST variable
	 * @param string $key     The key to retrieve from the $_REQUEST variable
	 * @param mixed  $default The default value to return if the key is not found in $_REQUEST (default is an empty string)
	 * @return mixed Returns the value associated with the key in $_REQUEST if found, otherwise returns the default value
	 */
	public function input(string $key, mixed $default = ''): mixed
	{
	    if (isset($_REQUEST[$key])) {
	        // If the key exists in $_REQUEST, return the corresponding value
	        return $_REQUEST[$key];
	    }

	    // If the key is not found in $_REQUEST, return the default value
	    return $default;
	}


	/**
	 * Get all values from the REQUEST variable
	 * @return mixed Returns an associative array containing all values from the $_REQUEST variable
	 */
	public function all(): mixed
	{
	    return $_REQUEST;
	}


}
