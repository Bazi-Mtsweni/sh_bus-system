<?php
define('BASE_DIR', realpath(dirname(__FILE__) . '/../..'));

require(BASE_DIR . '/config.php');
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
    <title>SHSS Commute Service Appliation - Bus Selection</title>

    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/user/user-styles.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/forms.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/user/learner-form.css' ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <?php
        include(BASE_DIR . "/includes/user-header.php");
        require(BASE_DIR . '/includes/alerts.php');
    ?>

    <main class="bus-selection">
        <a href="#" class="btn-blue">← Go back</a>

        <h2>Bus & Route Selection <span>(Step 2 of 2)</span></h2>
    </main>

    <?php require(BASE_DIR . "/includes/footer.php"); ?>

    <script type="module" src="<?php echo BASE_URL . "/js/parent-pages.js"; ?>"></script>
</body>

</html>