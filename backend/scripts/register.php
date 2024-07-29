<?php
require "../db/conn.php";
include "../includes/responses.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $parentName = isset($_POST["name"]) ? trim($_POST["name"]) : "";
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
    $tel = isset($_POST["tel"]) ? trim($_POST["tel"]) : "";

    if (empty($parentName) || empty($email) || empty($password) || empty($tel)) {
        response(false, "Please fix all errors and try again.");
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT email FROM parents WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            response(false, "Email already registered. Try logging in.");
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert into the database
            $stmt = $conn->prepare("INSERT INTO parents (parentName, email, password, tel) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $parentName, $email, $hashedPassword, $tel);

            if ($stmt->execute()) {
                // Create a session for the new user
                session_regenerate_id(true);
                setcookie(session_name(), session_id(), [
                    'expires' => time() + 86400, // Cookie expires in 1 day
                    'path' => '/',
                    'domain' => '', 
                    'secure' => false, 
                    'httponly' => true, 
                    'samesite' => 'Lax' 
                ]);
                $_SESSION["parent_id"] = session_id();
                $_SESSION["username"] = $parentName;
                redirect(true, '../user/user-dashboard.php');
                exit;
            } else {
                response(false, "Failed to register. Please try again.");
            }
        }
    }
} else {
    response(false, "Invalid request method.");
}

?>
