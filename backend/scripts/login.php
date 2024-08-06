<?php
require "../db/conn.php";

function response($bool, $msg)
{
    header('Content-Type: application/json');
    echo json_encode(array('error' => $bool, 'error' => $msg));
    exit;
}
function redirect($bool, $path)
{
    header('Content-Type: application/json');
    echo json_encode(array('success' => $bool, 'redirect' => $path));
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $initials = isset($_POST["initials"]) ? trim($_POST["initials"]) : "";
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
    $admin_id = isset($_POST["admin_id"]) ? trim($_POST["admin_id"]) : "";
    $bot_check = isset($_POST["bot-check"]);

    if (empty($email) || empty($password)) {
        response(false, "Please fix all errors and try again");
        $email = $_POST["email"];
        $password = $_POST["password"];
        $admin_id = $_POST["admin-id"];
        $initials = $_POST["initials"];
    }

    $admin_query = "SELECT * FROM admin WHERE email = ?";
    $parent_query = "SELECT * FROM parents WHERE email = ?";
    
    // Check if the user is an admin by checking if the admin id is not empty
    if (!empty($admin_id)) {
        $stmt = $conn->prepare($admin_query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $admin_result = $stmt->get_result();
        if ($admin_result->num_rows > 0) {
            $admin = $admin_result->fetch_assoc();
            if ($initials === $admin['initials']) { 
                if ($password === $admin['password']) { //Use password_verify() for hashed password
                    // Admin authenticated
                    session_regenerate_id(true);
                    setcookie(session_name(), session_id(), [
                        'expires' => time() + 86400, // Cookie expires in 1 day
                        'path' => '/',
                        'domain' => '', 
                        'secure' => false, 
                        'httponly' => true, 
                        'samesite' => 'Lax' 
                    ]);
                    $_SESSION["admin_id"] = $admin['adminId'];
                    $_SESSION["initials"] = $admin['initials'];
                    redirect(true, '../admin/admin-dashboard.php');
                    exit;
                } else {
                    response(false, "Please insert a valid password or reset it");
                    exit;
                }
                
            } else {
                response(false, "Your initials don't match with your account email");
                exit;
            }
        } else {
            response(false, "Incorrect email or it does not exist");
            exit;
        }
    }

    // Check if the user is a parent
    if ($stmt = $conn->prepare($parent_query)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $parent_result = $stmt->get_result();
        if ($parent_result->num_rows > 0) {
            $parent = $parent_result->fetch_assoc();
            if (password_verify($password, $parent['password'])) { 
                // Parent authenticated
                session_regenerate_id(true);
                setcookie(session_name(), session_id(), [
                    'expires' => time() + 86400, // Cookie expires in 1 day
                    'path' => '/',
                    'domain' => '', 
                    'secure' => false, 
                    'httponly' => true, 
                    'samesite' => 'Lax' 
                ]);
                $_SESSION["username"] = $parent['parentName'];
                $_SESSION["parent_id"] = $parent['parentId'];
                redirect(true, '../user/user-dashboard.php');
                exit;
            } else {
                response(false, "Please insert a valid password or reset it");
                exit;
            }
        } else {
            response(false, "Incorrect email or it does not exist");
        }
    }
} else {
    response(false, "Invalid request method");
}
