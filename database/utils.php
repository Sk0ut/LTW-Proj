<?php

require_once('connection.php');

/**
 * Execute a prepared statement query to the database
 * @param query query to be executed
 * @param params parameters of the query
 * @param types types of the parameters
 * @return result array if successfull, false otherwise
 */
function executeQuery($query, $params, $types) {
    // Check arguments
    if(count($params) != count($types))
        return false;

    global $db;

    // Prepare the statement
    $statement = $db->prepare($query);
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
    return $statement->fetchAll();
}

/**
 * Execute a prepared statement update in the database
 * @param query query to be executed
 * @param params parameters of the query
 * @param types types of the parameters
 * @return number of updated rows, false otherwise
 */
function executeUpdate($query, $params, $types) {
    // Check arguments
    if(count($params) != count($types))
        return false;

    global $db;

    // Prepare the statement
    $statement = $db->prepare($query);
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
    return $statement->numRows;
}
?>
