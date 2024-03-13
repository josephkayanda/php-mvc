<?php

namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

/** 
 * Main Model trait 
 */
trait Model
{
    use Database; // Using the Database trait for database operations

    // Default values for pagination and ordering
    protected $limit        = 10;
    protected $offset       = 0;
    protected $order_type   = "desc";
    protected $order_column = "id";
    
    public $errors          = []; // Array to store errors during model operations

    // Method to fetch all records from the database
    public function findAll()
    {
        $query = "SELECT * FROM $this->table ORDER BY $this->order_column $this->order_type LIMIT $this->limit OFFSET $this->offset";
        
        return $this->query($query);
    }

    // Method to fetch records based on conditions from the database
    public function where($data, $data_not = [])
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "SELECT * FROM $this->table WHERE ";

        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . " AND ";
        }

        foreach ($keys_not as $key) {
            $query .= $key . " != :" . $key . " AND ";
        }

        $query = trim($query, " AND ");

        $query .= "ORDER BY $this->order_column $this->order_type LIMIT $this->limit OFFSET $this->offset";
        $data = array_merge($data, $data_not);
        
        return $this->query($query, $data);
    }

    // Method to fetch the first record based on conditions from the database
    public function first($data, $data_not = [])
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "SELECT * FROM $this->table WHERE ";

        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . " AND ";
        }

        foreach ($keys_not as $key) {
            $query .= $key . " != :" . $key . " AND ";
        }

        $query = trim($query, " AND ");

        $query .= " LIMIT $this->limit OFFSET $this->offset";
        $data = array_merge($data, $data_not);

        $result = $this->query($query, $data);
        if ($result) {
            return $result[0];
        }
        return false;
    }

    // Method to insert a new record into the database
    public function insert($data)
    {
        // Remove unwanted data based on allowedColumns
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }
        
        $keys = array_keys($data);
        $query = "INSERT INTO $this->table (" . implode(',', $keys) . ") VALUES (:" . implode(',:', $keys) . ")";
        $this->query($query, $data);
    
        return false;
    }

    // Method to update a record in the database
    public function update($id, $data, $id_column = 'id')
    {
        // Remove unwanted data
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                unset($data[$key]);
            }
        }

        $keys = array_keys($data);
        $query = "UPDATE $this->table SET ";
       
        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . ", ";
        }

        $query = trim($query, ", ");

        $query .= " WHERE $id_column = :$id_column";
        $data[$id_column] = $id;
        $this->query($query, $data);
    }

    // Method to delete a record from the database
    public function delete($id, $id_column = 'id')
    {
        $data[$id_column] = $id;
        $query = "DELETE FROM $this->table WHERE $id_column = :$id_column";
        $this->query($query, $data);
    
        return false;
    }
}
