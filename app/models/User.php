<?php 

namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * User class
 */
class User
{
    use Model; // Using the Model trait for common database methods

    protected $table = 'users'; // Database table name

    protected $allowedColumns = [
        'email',
        'password',
    ]; // Allowed columns for insert and update operations

    public function validate($data)
    {
        $this->errors = []; // Initialize the errors array

        // Validate email
        if (empty($data['email'])) {
            $this->errors['email'] = "Email is required";
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Email is not valid";
        }
        
        // Validate password
        if (empty($data['password'])) {
            $this->errors['password'] = "Password is required";
        }
        
        // Validate acceptance of terms
        if (empty($data['terms'])) {
            $this->errors['terms'] = "Please accept the terms and conditions";
        }

        // Return true if there are no errors, indicating successful validation
        if (empty($this->errors)) {
            return true;
        }

        // Return false if there are validation errors
        return false;
    }
}
