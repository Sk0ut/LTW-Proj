<?php

/**
 * Database Object
 */
class Database {

    /**
     * Connection to the database
     */
    private $_connection;

    /**
     * Constructor of Database.
     */
    public function __construct() {  }

    /**
     * Open a connection to a database
     * Will try to open the database in the same directory as
     * the file that created the database, if unable then will try
     * to open from the parent folder of the current file
     * in last case will try to open from the root directory
     * @param fileName name of the database's file
     * @return true if successfull, false otherwise
     */
    public function openConnection($fileName) {
        $path = $fileName;
        if(!file_exists($path))
            $path = '../database/'.$fileName;
        if(!file_exists($path))
            $path = 'database/'.$fileName;
        if(!file_exists($path))
            return false;

        try {
            $this->_connection = new PDO('sqlite:'.$path);
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }

    /**
     * Execute a prepared statement query to the database
     * @param query query to be executed
     * @param params parameters of the query
     * @param types types of the parameters
     * @return result array if successfull, false otherwise
     */
    public function executeQuery($query, $params, $types) {
        // Check arguments
        if(count($params) != count($types))
            return false;

        // Prepare the statement
        $statement = $this->_connection->prepare($query);
        if(!$statement)
            return false;

        // Bind parameters
        $index = 0;
        foreach($params as $param)
            $statement->bindParam($index + 1, $param, $types[$index++]);

        // Execute update
        $statement->execute();

        // Return response
        if(!$statement)
            return false;
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Execute a prepared statement update in the database
     * @param query query to be executed
     * @param params parameters of the query
     * @param types types of the parameters
     * @return number of updated rows, false otherwise
     */
    public function executeUpdate($query, $params, $types) {
        // Check arguments
        if(count($params) != count($types))
            return false;

        // Prepare the statement
        $statement = $this->_connection->prepare($query);
        if(!$statement)
            return false;

        // Bind parameters
        $index = 0;
        foreach($params as $param)
            $statement->bindParam($index + 1, $param, $types[$index++]);

        // Execute update
        $statement->execute();

        // Return response
        if(!$statement)
            return false;
        return $statement->rowCount();
    }
}

// Create database
$database = new Database();
$database->openConnection('events.db');
?>
