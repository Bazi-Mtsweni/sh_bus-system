<?php
session_start();
require realpath(dirname(__DIR__)) . '/../public/config.php';

// Unset all of the session variables
$_SESSION = array();

// Delete the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

header("Location: ". BASE_URL ."/views/forms/admin-form.php");
exit();
?>