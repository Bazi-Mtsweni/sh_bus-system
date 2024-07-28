<?php

require "../db/conn.php";

function dd($dump)
{
    echo '<pre>', print_r($dump, true), '</pre>';
    die();
}

function executeQuery($sql, $data)
{
    global $conn;
    $stmt = $conn->prepare($sql); //connect to db and prepare the sql statement
    $values = array_values($data); //extract only the values from the conditions
    $types = str_repeat('s', count($values)); //determine how many strings (s) are there based on the number of values counted. Why 's'? Because mysql will automatically change a number to data type int, so it doesn't matter.
    $stmt->bind_param($types, ...$values); //bind the values to the number of data types for execution
    $stmt->execute(); //execute the statement
    return $stmt;
}

// ------------------------------------------------ SELECT ALL -----------------------------------------------
function selectAll($table, $conditions = [])
{
    //Connection string to the DB
    global $conn;

    //Sql query for a select all statement
    $sql = "SELECT * FROM $table";

    //if there are no spwcified conditions, return everything
    if (empty($conditions)) {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    } else {
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " WHERE $key=?";
            } else {
                $sql = $sql . " AND $key=?";
            }
            $i++;
        }

        $stmt = executeQuery($sql, $conditions);
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); //get all records as an associative array
        return $records; //return them for use.
    }
}
