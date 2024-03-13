<?php

/**
 * Session class
 * Save or read data to the current session
 */

namespace Core;

defined('ROOTPATH') OR exit('Access Denied!');

class Session
{

	public $mainkey = 'APP';
	public $userkey = 'USER';
	
	/**
	 * Activate session if not yet started
	 */
	private function start_session(): int
	{
	    // Check if the session has not been started yet
	    if (session_status() === PHP_SESSION_NONE) {
	        // If not started, initiate the session
	        session_start();
	    }

	    // Return 1 to indicate success (session either started or already active)
	    return 1;
	}


	/**
	* Put data into the session
	*/
	public function set(mixed $keyOrArray, mixed $value = ''): int
	{
	    // Ensure the session is started
	    $this->start_session();

	    // Check if the provided keyOrArray is an array
	    if (is_array($keyOrArray)) {
	        // If it's an array, iterate through each key-value pair
	        foreach ($keyOrArray as $key => $value) {
	            // Store each key-value pair in the session under the main key
	            $_SESSION[$this->mainkey][$key] = $value;
	        }

	        // Return 1 to indicate success
	        return 1;
	    }

	    // If keyOrArray is not an array, store the single key-value pair in the session
	    $_SESSION[$this->mainkey][$keyOrArray] = $value;

	    // Return 1 to indicate success
	    return 1;
	}

	 /**
	 * Get data from the session. Default is returned if data not found.
	 *
	 * @param string $key     The key to retrieve from the session
	 * @param mixed $default  The default value to return if the key is not found in the session (default is an empty string)
	 *
	 * @return mixed Returns the value associated with the key if found, otherwise returns the default value
	 */
	public function get(string $key, mixed $default = ''): mixed
	{
	    // Ensure the session is started
	    $this->start_session();

	    // Check if the key exists in the session
	    if (isset($_SESSION[$this->mainkey][$key])) {
	        // If the key exists, return the corresponding value
	        return $_SESSION[$this->mainkey][$key];
	    }

	    // If the key is not found, return the default value
	    return $default;
	}

	 /**
	 * Saves the user row data into the session after a login
	 *
	 * @param mixed $user_row The user row data to be stored in the session
	 *
	 * @return int Returns 0 to indicate success
	 */
	public function auth(mixed $user_row): int
	{
	    // Ensure the session is started
	    $this->start_session();

	    // Store the user row data in the session under the specified user key
	    $_SESSION[$this->userkey] = $user_row;

	    // Return 0 to indicate success
	    return 0;
	}

	 
	 /**
	 * Removes user data from the session
	 *
	 * @return int Returns 0 to indicate success
	 */
	public function logout(): int
	{
	    $this->start_session();

	    // Check if user data is present in the session
	    if (!empty($_SESSION[$this->userkey])) {
	        // If user data is present, remove it from the session
	        unset($_SESSION[$this->userkey]);
	    }

	    // Return 0 to indicate success
	    return 0;
	}


	 /**
	 * Gets data from a column in the session user data
	 *
	 * @param string $key      The key or column name to retrieve from the session user data
	 * @param mixed  $default  The default value to return if the key is not found in the session user data (default is an empty string)
	 *
	 * @return mixed Returns the value associated with the key or column name if found, otherwise returns the default value
	 */
	public function user(string $key = '', mixed $default = ''): mixed
	{
	    $this->start_session();

	    // Check if $key is empty and user data is present in the session
	    if (empty($key) && !empty($_SESSION[$this->userkey])) {
	        // If $key is empty, return the entire user data
	        return $_SESSION[$this->userkey];
	    } else if (!empty($_SESSION[$this->userkey]->$key)) {
	        // If $key is not empty and the specified key exists in the user data, return its value
	        return $_SESSION[$this->userkey]->$key;
	    }

	    // If $key is not found, return the default value
	    return $default;
	}


	 /**
	 * Returns data from a key and deletes it from the session
	 *
	 * @param string $key     The key to retrieve from the session
	 * @param mixed  $default The default value to return if the key is not found in the session (default is an empty string)
	 *
	 * @return mixed Returns the value associated with the key if found, otherwise returns the default value
	 */
	public function pop(string $key, mixed $default = ''): mixed
	{
	    $this->start_session();

	    // Check if the key exists in the session
	    if (!empty($_SESSION[$this->mainkey][$key])) {
	        // If the key exists, retrieve its value
	        $value = $_SESSION[$this->mainkey][$key];

	        // Remove the key from the session
	        unset($_SESSION[$this->mainkey][$key]);

	        // Return the retrieved value
	        return $value;
	    }

	    // If the key is not found, return the default value
	    return $default;
	}

	 
	 /**
	 * Returns all data from the APP array in the session
	 *
	 * @return mixed Returns an array containing all data from the APP array, or an empty array if the key is not found
	 */
	public function all(): mixed
	{
	    $this->start_session();

	    // Check if the main key exists in the session
	    if (isset($_SESSION[$this->mainkey])) {
	        // If the main key exists, return all data under that key
	        return $_SESSION[$this->mainkey];
	    }

	    // If the main key is not found, return an empty array
	    return [];
	}

}
