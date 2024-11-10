<?php
include "../db/conn.php";
include "../includes/responses.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['studentId'])) {
    $studentId = $_POST['studentId'];

    // Start a transaction to ensure both deletions succeed
    $conn->begin_transaction();

    try {
        // Delete from registrations table
        $sql = "DELETE FROM registrations WHERE studentId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $studentId);
        $stmt->execute();

        // Delete from students table
        $sql = "DELETE FROM students WHERE studentId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $studentId);
        $stmt->execute();

        // Commit the transaction
        $conn->commit();
        response(true, "Application deleted successfully.");

    } catch (Exception $e) {
        // Rollback if any query fails
        $conn->rollback();
        response(false, "Error deleting application.");
    }

    $stmt->close();
    $conn->close();

} else {
    response(false, "Invalid request.");
}
?>
