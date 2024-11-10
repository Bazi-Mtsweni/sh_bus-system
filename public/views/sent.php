<?php
define('BASE_DIR', realpath(dirname(__FILE__) . '/..'));
require("../config.php");

require(ROOT_PATH . '/backend/db/conn.php');

if (!isset($_SESSION["parent_id"])) {
    header("Location: http://localhost/sh-bus-system/public");
}

$username = $_SESSION["username"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SHSS Commute Service Appliation - Thank You!</title>

    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/user/user-styles.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/forms.css' ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <?php
    include(BASE_DIR . "/includes/user-header.php");
    $button_text = "Go To Dashboard";
    $link = "./user/user-dashboard.php";
    $body = "Thank you " . explode(" ", $username)[0] . ", you will receive an email confirming your application. We advise that you constantly login to the system to view any changes on your application status. For further assistance please contact Strive High Secondary School on +27 81 319 9670.";
    $title = "Your Application Has been Received";

    require(BASE_DIR . "/includes/hero.php");
    ?>
  

    <?php require(BASE_DIR . "/includes/footer.php"); ?>
</body>

</html>