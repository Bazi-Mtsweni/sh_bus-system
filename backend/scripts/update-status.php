<?php
include '../db/conn.php'; 

header('Content-Type: application/json');
$response = array('success' => false, 'message' => '', 'newStatus' => '');

if (isset($_GET['action']) && isset($_GET['student_id'])) {
    $action = $_GET['action'];
    $studentId = intval($_GET['student_id']);
    
    switch ($action) {
        case 'return_to_waiting':
            $query = "UPDATE registrations SET approved = 0, waiting = 1, canceled = 0 WHERE studentId = $studentId";
            $newStatus = 'waiting';
            break;
        case 'remove_student':
            $query = "DELETE FROM registrations WHERE studentId = $studentId";
            $newStatus = 'removed';
            break;
        case 'approve_student':
            $query = "UPDATE registrations SET approved = 1, waiting = 0, canceled = 0 WHERE studentId = $studentId";
            $newStatus = 'approved';
            break;
        case 'decline_student':
            $query = "UPDATE registrations SET approved = 0, waiting = 0, canceled = 1 WHERE studentId = $studentId";
            $newStatus = 'canceled';
            break;
        case 'add_to_waiting':
            $query = "UPDATE registrations SET approved = 0, waiting = 1, canceled = 0 WHERE studentId = $studentId";
            $newStatus = 'waiting';
            break;
        default:
            $response['message'] = 'Invalid action';
            echo json_encode($response);
            exit;
    }

    if ($conn->query($query) === TRUE) {
        $response['success'] = true;
        $response['newStatus'] = $newStatus;
        $response['message'] = 'Status successfully updated.';
    } else {
        $response['message'] = 'Database update failed';
    }
} else {
    $response['message'] = 'Missing parameters';
}

echo json_encode($response);
?>
