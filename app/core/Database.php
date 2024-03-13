<?php

namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * Database trait
 */
trait Database
{
    /**
     * Establish a database connection using PDO
     * @return PDO The PDO database connection
     */
    private function connect()
    {
        $string = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);
        return $con;
    }

    /**
     * Execute a query and fetch all results
     * @param string $query The SQL query to execute
     * @param array  $data  An associative array of parameters for the prepared statement
     * @return array|false An array of results or false on failure
     */
    public function query($query, $data = [])
    {
        $con = $this->connect();
        $stm = $con->prepare($query);
        $check = $stm->execute($data);

        if ($check) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            if (is_array($result) && count($result)) {
                return $result;
            }
        }

        return false;
    }

    /**
     * Execute a query and fetch the first row
     * @param string $query The SQL query to execute
     * @param array  $data  An associative array of parameters for the prepared statement
     * @return object|false The first row as an object or false on failure
     */
    public function get_row($query, $data = [])
    {
        $con = $this->connect();
        $stm = $con->prepare($query);
        $check = $stm->execute($data);

        if ($check) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            if (is_array($result) && count($result)) {
                return $result[0];
            }
        }

        return false;
    }
}
