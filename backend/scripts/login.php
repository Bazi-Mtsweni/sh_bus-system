<?php
session_start();

function response($bool, $msg)
{
    header('Content-Type: application/json');
    echo json_encode(array('success' => $bool, 'error' => $msg));
    exit;
}
function redirect($bool, $path)
{
    header('Content-Type: application/json');
    echo json_encode(array('success' => $bool, 'redirect' => $path));
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = isset($_POST["username"]) ? trim($_POST["username"]) : "";
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
    $admin_id = isset($_POST["admin_id"]) ? trim($_POST["admin_id"]) : "";
    $bot_check = isset($_POST["bot-check"]);

    if (empty($username) || empty($password)) {
        response(false, "Please fix all errors and try again");
        $username = $_POST["username"];
        $password = $_POST["password"];
        $admin_id = $_POST["admin-id"];
    }

    // Dummy authentication logic
    // Replace this with actual authentication code (e.g., checking username and password in the database)
    $is_authenticated = true; // Assume authentication is successful for example purposes

    if ($is_authenticated) {
        // Regenerate session ID to prevent session fixation attacks
        session_regenerate_id(true);

        // Set a session cookie using the session ID
        setcookie(session_name(), session_id(), [
            'expires' => time() + 86400, // Cookie expires in 1 day
            'path' => '/',
            'domain' => '', 
            'secure' => false, 
            'httponly' => true, 
            'samesite' => 'Lax' 
        ]);


        if (isset($_POST["admin_id"]) && $admin_id === "ICT3715") {
            $_SESSION["admin_id"] = $admin_id;
            $_SESSION["username"] = $username;
            redirect(true, '../admin/admin-dashboard.php');
        } else {
            redirect(true, '../user/user-dashboard.php');
        }
    } else {
        response(false, "Invalid username or password");
    }
} else {
    response(false, "Invalid request method");
}
