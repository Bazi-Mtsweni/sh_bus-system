<?php
require "../db/conn.php";
include "../includes/responses.php";
header('Content-Type: application/json');

$bus_number = $_GET['bus_number'] ?? '';

// Prepare and execute queries if the bus number is provided
if (!empty($bus_number)) {
    // Morning pickup query
    $morningQuery = $conn->prepare("
        SELECT morning_pickup_number AS number, morning_pickup_name AS location, DATE_FORMAT(morning_pickup_time, '%H:%i') AS time
        FROM routes
        WHERE bus_number = ?
    ");
    $morningQuery->bind_param("s", $bus_number);
    $morningQuery->execute();
    $morningPickups = $morningQuery->get_result()->fetch_all(MYSQLI_ASSOC);

    // Afternoon drop-off query
    $afternoonQuery = $conn->prepare("
        SELECT afternoon_dropoff_number AS number, afternoon_dropoff_name AS location, DATE_FORMAT(afternoon_dropoff_time, '%H:%i') AS time
        FROM routes
        WHERE bus_number = ?
    ");
    $afternoonQuery->bind_param("s", $bus_number);
    $afternoonQuery->execute();
    $afternoonDropoffs = $afternoonQuery->get_result()->fetch_all(MYSQLI_ASSOC);
    
    // Output data as JSON
    echo json_encode([
        'morning_pickups' => $morningPickups,
        'afternoon_dropoffs' => $afternoonDropoffs
    ]);
    
} else {
    response(false, "No bus number provided");
}

