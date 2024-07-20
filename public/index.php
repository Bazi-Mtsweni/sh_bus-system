<?php
ob_start();
require('config.php');
define('BASE_DIR', realpath(dirname(__FILE__) . '/'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strive High Secondary School - Home</title>

    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php require('./includes/header.php'); ?>
    <?php 
        $button_text = "Apply For Your Child";
        $link = "#";
        $title = "Convenient and Safe Transportation for All Students";
        $body = "Strive High Secondary School introduces a new bus registration system designed to ensure safe and efficient transportation for our learners. Sign up today to secure a seat for your child next year.";
        require(BASE_DIR . "/includes/hero.php"); 
    ?>

    

    This is a public page

    <a href="" target="_blank" rel="noopener noreferrer">Sign Up</a>
    <a href="<?php echo BASE_URL . '/views/forms/login-form.php' ?>" target="_blank" rel="noopener noreferrer">Log In</a>

    <script src="./js/index.js"></script>
</body>

</html>