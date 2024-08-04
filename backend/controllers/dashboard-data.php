<?php

require __DIR__ . '/../includes/sql-functions.php';

$all_applications = countAll("registrations");
$bus_capacities = selectColumn("buses", "capacity");
$total_approved_students = countBusStudents();
$approved_students = getStudentsPerGrade('approved');
$canceled_students = getStudentsPerGrade('canceled');
$waiting_students = getStudentsPerGrade('waiting');

function dataPerGrade($rawData){
    // Initialize an array for all grades
    $grades = array('8' => 0, '9' => 0, '10' => 0, '11' => 0, '12' => 0);

    foreach ($rawData as $student_data) {
        $grades[$student_data['grade']] = $student_data['total_students'];
    }

    return $grades;
};
