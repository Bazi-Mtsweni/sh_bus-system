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

    <title>Strive High Secondary School - Application Status</title>

    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/user/user-styles.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/user/app-status.css' ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <?php
    include(BASE_DIR . "/includes/user-header.php");
    $button_text = "";
    $link = "";
    $title = "Application Status";
    $body = "Below is a list of all your children enrolled in our school that you have appllied for to use the bus in 2025 and their application statuses.";
    require(BASE_DIR . "/includes/hero.php");
    require(BASE_DIR . "/includes/alerts.php");
    ?>

    <main>
        <section class="status-table">
            <h2>Students Application Status</h2>
            <table id="learner-status">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Grade</th>
                        <th>Contact Number</th>
                        <th>Bus Name</th>
                        <th>Morning Use</th>
                        <th>Afternoon Use</th>
                        <th>Status</th>
                        <th class="table-actions">Actions</th>
                    </tr>
                </thead>
                <tbody id="learner-status-body">
                    <!-- Content will go here -->
                </tbody>
            </table>

            <div class="instructions flex">
                <i class="fa-solid fa-circle-info"></i>
                <p class="instruction">If you have any queries please don't hesitate to contact our admin on +27 81 319 9670. Thank you!</p>
            </div>
        </section>
    </main>


    <?php require(BASE_DIR . "/includes/footer.php"); ?>

    <script src="<?php echo BASE_URL . "/js/status.js"; ?>"></script>
</body>

</html>