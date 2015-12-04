<?php

/**
 * Database Object
 */
class Database {

    /**
     * Instance of the database
     */
    private static $_instance = NULL;

    /**
     * Connection to the database
     */
    private $_connection;

    /**
     * Get the instance of the database
     * @return instance of the database
     */
    public static function getInstance() {
        if(self::$_instance == NULL) {
            self::$_instance = new Database();
            self::$_instance->openConnection(__DIR__ . '/../../db/events.db');
        }
        return self::$_instance;
    }

    /**
     * Open a connection to a database
     * Will try to open the database in the same directory as
     * the file that created the database, if unable then will try
     * to open from the parent folder of the current file
     * in last case will try to open from the root directory
     * @param path path to the database's file
     * @return true if successfull, false otherwise
     */
    public function openConnection($path) {
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
            $statement->bindValue($index + 1, $param, $types[$index++]);

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
        foreach($params as $param) {
            $statement->bindValue($index + 1, $param, $types[$index]);
            $index++;
        }

        // Execute update
        $statement->execute();

        // Return response
        if(!$statement)
            return false;
        return $statement->rowCount();
    }
}

?>
