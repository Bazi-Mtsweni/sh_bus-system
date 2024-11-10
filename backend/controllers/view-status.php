<?php
include "../db/conn.php";

$parentId = $_SESSION['parent_id']; 

$sql = "SELECT 
            s.studentId,
            s.studentName,
            s.grade,
            s.tel,
            b.bus_name,
            s.pickup_number IS NOT NULL AS morning_use,
            s.dropoff_number IS NOT NULL AS afternoon_use,
            COALESCE(r.waiting, NULL) AS waiting,
            COALESCE(r.approved, NULL) AS approved,
            COALESCE(r.canceled, NULL) AS canceled
        FROM students s
        LEFT JOIN registrations r ON s.studentId = r.studentId
        LEFT JOIN buses b ON r.busId = b.busId
        WHERE s.parentId = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $parentId);
$stmt->execute();
$result = $stmt->get_result();

$learners = [];
while ($row = $result->fetch_assoc()) {
    // Determine status based on registration data
    if ($row['approved']) {
        $status = "Approved";
    } elseif ($row['waiting']) {
        $status = "Waiting";
    } elseif ($row['canceled']) {
        $status = "Canceled";
    } else {
        $status = "Rejected";  // Student is not in the registrations table
    }

    $learners[] = [
        'studentId' => $row['studentId'],
        'studentName' => $row['studentName'],
        'grade' => $row['grade'],
        'tel' => $row['tel'],
        'bus_name' => $row['bus_name'] ?? "N/A",
        'morning_use' => $row['morning_use'],
        'afternoon_use' => $row['afternoon_use'],
        'status' => $status
    ];
}
$stmt->close();
$conn->close();

echo json_encode($learners);
?>
