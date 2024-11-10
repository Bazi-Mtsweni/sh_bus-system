<?php
require '../db/conn.php'; 

if (isset($_POST['notificationId'])) {
    $notificationId = $_POST['notificationId'];
    // Update the notification to mark it as read
    $sql = "DELETE FROM notifications WHERE notificationId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $notificationId);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
}
$conn->close();