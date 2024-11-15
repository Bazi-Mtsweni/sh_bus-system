<?php
error_reporting(E_ALL);
ini_set('display_errors', 'Off');

require realpath(dirname(__DIR__)) . '/db/conn.php';

$specific_date = '2024-08-05'; //This is for the DB function for development - to be changed later
$type = isset($_GET['type']) ? $_GET['type'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Create an array of the past 7 days
$days = array();
for ($i = 0; $i < 7; $i++) {
    $days[] = date('Y-m-d', strtotime("-$i days"));
}
$days = array_reverse($days);

function fetch_list($conn, $type, $search)
{
    $condition = '';
    switch ($type) {
        case 'approved':
            $condition = "reg.approved = TRUE AND reg.canceled = FALSE AND reg.waiting = FALSE";
            break;
        case 'waiting':
            $condition = "reg.waiting = TRUE AND reg.approved = FALSE AND reg.canceled = FALSE";
            break;
        case 'canceled':
            $condition = "reg.canceled = TRUE AND reg.approved = FALSE AND reg.waiting = FALSE";
            break;
        default:
            return false;
    }

    $search_condition = '';
    if ($search) {
        $search = $conn->real_escape_string($search);
        $search_condition = " AND (s.studentName LIKE '%$search%' OR b.bus_name LIKE '%$search%' OR reg.date LIKE '%$search%')";
    }

    $sql = "
    SELECT DISTINCT
        s.studentName,
        s.studentId, 
        s.grade, 
        s.tel AS studentTel, 
        p.parentName, 
        p.email AS parentEmail, 
        b.bus_name, 
        b.capacity, 
        CASE 
            WHEN s.pickup_number IS NOT NULL THEN 'Yes' 
            ELSE 'No' 
        END AS morning_use, 
        CASE 
            WHEN s.dropoff_number IS NOT NULL THEN 'Yes' 
            ELSE 'No' 
        END AS afternoon_use,
        DATE(reg.date) AS reg_date
    FROM 
        registrations reg
    JOIN 
        students s ON reg.studentId = s.studentId
    JOIN 
        parents p ON s.parentId = p.parentID
    JOIN 
        buses b ON reg.busId = b.busId
    JOIN 
        routes r ON b.bus_number = r.bus_number
    WHERE 
        reg.date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND $condition $search_condition
    ORDER BY 
        s.studentName
    ";

    return $conn->query($sql);
}

$result = fetch_list($conn, $type, $search);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['studentName']}</td>
                <td>{$row['grade']}</td>
                <td>{$row['studentTel']}</td>
                <td>{$row['bus_name']}</td>
                <td>{$row['morning_use']}</td>
                <td>{$row['afternoon_use']}</td>
                <td>{$row['reg_date']}</td>
                <td class='actions-cell'>"
                    . addActions($type, $row['studentId']) .
                "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='9' style='text-align: center;'></td></tr>";
}

function addActions($type, $studentId) {
    $actions = "";
    switch ($type) {
        case 'approved':
            $actions = "
                <button onclick='updateStatus(\"return_to_waiting\", {$studentId})' class='action btn-blue'><i class='fa-solid fa-hourglass-half'></i>Return To Waiting List</button>
                <button onclick='updateStatus(\"decline_student\", {$studentId})' class='action btn-red'><i class='fa-solid fa-ban'></i>Remove Student</button>";
            break;
        case 'waiting':
            $actions = "
                <button onclick='updateStatus(\"approve_student\", {$studentId})' class='action btn-blue'><i class='fa-solid fa-check'></i>Approve Student</button>
                <button onclick='updateStatus(\"decline_student\", {$studentId})' class='action btn-red'><i class='fa-solid fa-ban'></i>Decline Student</button>";
            break;
        case 'canceled':
            $actions = "
                <button onclick='showModal({$studentId})' class='action btn-red'><i class='fa-solid fa-trash-can'></i>Delete Application</button>";
            break;
        default:
            break;
    }
    return $actions;
}


function getWeeklyData($status)
{
    global $conn;

    $sql = "
    SELECT
        DATE(r.date) AS day,
        COUNT(r.registrationId) AS total_students
    FROM
        registrations r
    WHERE
        r.$status = TRUE AND
        r.date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    GROUP BY
        DATE(r.date)
    ORDER BY
        DATE(r.date);
    ";

    $result = $conn->query($sql);
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[$row['day']] = $row['total_students'];
    }

    return $data;
}

function WeeklyApprovedDataPerGrade()
{
    global $conn;

    $sql = "
    SELECT
        s.grade,
        COUNT(r.registrationId) AS total_students
    FROM
        students s
    LEFT JOIN
        registrations r ON s.studentId = r.studentId
    WHERE
        r.approved = TRUE AND
        r.date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    GROUP BY
        s.grade
    ORDER BY
        s.grade;
    ";

    $result = $conn->query($sql);
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[$row['grade']] = $row['total_students'];
    }

    return $data;
}

function fetch_bus_usage($conn)
{
    $sql = "
    SELECT 
        b.bus_name,
        s.pickup_number IS NOT NULL AS morning_use,
        s.dropoff_number IS NOT NULL AS afternoon_use
    FROM 
        students s
    JOIN 
        buses b ON s.bus_number = b.bus_number
    JOIN 
        registrations reg ON s.studentId = reg.studentId
    WHERE 
        reg.date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND reg.approved = TRUE 
    GROUP BY 
        b.bus_name
    ORDER BY 
        b.bus_name;
    ";

    $result = $conn->query($sql);
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    return $data;
}



//Call functions to return data
$approvedDataPerGrade = WeeklyApprovedDataPerGrade();
$approvedData = getWeeklyData('approved');
$waitingData = getWeeklyData('waiting');
$busUsageData = fetch_bus_usage($conn);

$busNames = [];
$morningUse = [];
$afternoonUse = [];

foreach ($busUsageData as $data) {
    $busNames[] = $data['bus_name'];
    $morningUse[] = $data['morning_use'];
    $afternoonUse[] = $data['afternoon_use'];
}

// Initialize data arrays for approved and waiting students
$approvedStudents = array_fill(0, 7, 0);
$waitingStudents = array_fill(0, 7, 0);

foreach ($days as $index => $day) {
    if (isset($approvedData[$day])) {
        $approvedStudents[$index] = $approvedData[$day];
    }
    if (isset($waitingData[$day])) {
        $waitingStudents[$index] = $waitingData[$day];
    }
}

// Initialize data arrays for grades and counts
$grades = ['8', '9', '10', '11', '12'];
$approvedStudentsPerGrade = array_fill(0, 5, 0);

foreach ($grades as $index => $grade) {
    if (isset($approvedDataPerGrade[$grade])) {
        $approvedStudentsPerGrade[$index] = $approvedDataPerGrade[$grade];
    }
}
