<?php

require __DIR__ . '/../includes/sql-functions.php';

$all_applications = countAll("registrations");
$bus_capacities = selectColumn("buses", "capacity");



// // Return the data as JSON
// header('Content-Type: application/json');
// echo json_encode($bus_capacities);

?>