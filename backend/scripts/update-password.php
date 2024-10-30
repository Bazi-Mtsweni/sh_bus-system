<?php
require "../db/conn.php";
include "../includes/responses.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $newPassword = trim($_POST['password']);

    if (!empty($newPassword) && !empty($email)) {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $stmt = $conn->prepare("UPDATE parents SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashedPassword, $email);

        if ($stmt->execute()) {
            // Delete the reset token to prevent reuse
            $stmt = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();

            response(true, "Your password has been reset successfully. You can now <a href='login.php'>log in</a>.") ;
        } else {
            response(false, "Failed to update password. Please try again.");
        }
    } else {
        response(false, "Please enter a valid password.") ;
    }
} else {
    response(false, "Invalid request.");
}
?>
