<?php

define('BASE_DIR', realpath(dirname(__FILE__) . '/../..'));

require(BASE_DIR . '/config.php');
require(ROOT_PATH . '/backend/db/conn.php');

if (!isset($_SESSION["admin_id"])) { 
    header("Location: http://localhost/sh-bus-system/public");
}

$username = isset($_SESSION["username"]) ? $_SESSION["username"] : "";
$date = date('j F Y');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/admin-styles.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/admin-dashboard.css' ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="">
    <?php include(BASE_DIR . "/includes/admin-header.php"); ?>
    <h2 class="intro">Welcome to admin, <?php echo $username?></h2>
    <section class="dash-nav">
        <?php include(BASE_DIR . "/includes/admin-nav.php"); ?>
        <div class="dashboard">
            <div class="actions">
                <button class="daily" onclick="printReport();"><a href="#daily-report"></a>Generate Daily Report</button>
                <button class="weekly">Generate Weekly Report</button>
            </div>
            <div class="cards">
                <div class="card date">
                    <span class="bg"></span>
                    <div class="icon">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <h3>Today&apos;s Date</h3>
                    <p><?php echo $date; ?></p>
                    <a href="#" class="button"> New Applicants </a>
                </div>
                <div class="card user-profile">
                    <span class="bg"></span>
                    <div class="image-container icon">
                        <img src="<?php echo BASE_URL . '/images/profile-picture.png'; ?>" alt="User Profile Image">
                    </div>
                    <h3><?php echo $username?></h3>
                    <p>Super Admin</p>
                    <a href="#" class="button">Manage Profile</a>
                </div>
                <div class="card applications">
                    <span class="bg"></span>
                    <div class="icon">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <h3>Applications</h3>
                    <p>25</p>
                    <a href="#" class="button">View Applications</a>
                </div>
                <div class="card waiting">
                    <span class="bg"></span>
                    <div class="icon">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <h3>Waiting</h3>
                    <p>12</p>
                    <a href="#" class="button"> More Details... </a>
                </div>
                <div class="card approved">
                    <span class="bg"></span>
                    <div class="icon">
                        <i class="fa-solid fa-thumbs-up"></i>
                    </div>
                    <h3>Approved</h3>
                    <p>12</p>
                    <a href="#" class="button"> More Details... </a>
                </div>
                <div class="card cancelled">
                    <span class="bg"></span>
                    <div class="icon">
                        <i class="fa-solid fa-ban"></i>
                    </div>
                    <h3>Cancelled</h3>
                    <p>3</p>
                    <a href="#" class="button"> More Details... </a>
                </div>
            </div>
        </div>
    </section>

    <section class="daily-report" id="daily-report">
        <h2>Daily Report - <?php echo $date; ?></h2>
        <div class="waiting">
            <h3>Students Waiting</h3>
            <div class="search">
                <input type="search" name="table-search" id="waiting-search" placeholder="What are you looking for?">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <table id="waiting-table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Grade</th>
                        <th>Contact Number</th>
                        <th>Parent Name</th>
                        <th>Parent Email</th>
                        <th>Bus Name</th>
                        <th>Bus Capacity</th>
                        <th>Morning Use</th>
                        <th>Afternoon Use</th>
                    </tr>
                </thead>
                <tbody id="waiting-table-body">
                    <!-- FETCHED DATA WILL APPEAR HERE -->
                </tbody>
            </table>
        </div>
        <div class="approved">
            <h3>Students Approved</h3>
            <div class="search">
                <input type="search" name="table-search" id="approved-search" placeholder="What are you looking for?">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <table id="approved-table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Grade</th>
                        <th>Contact Number</th>
                        <th>Parent Name</th>
                        <th>Parent Email</th>
                        <th>Bus Name</th>
                        <th>Bus Capacity</th>
                        <th>Morning Use</th>
                        <th>Afternoon Use</th>
                    </tr>
                </thead>
                <tbody id="approved-table-body">
                    <!-- FETCHED DATA WILL APPEAR HERE -->
                </tbody>
            </table>
        </div>
        <div class="cancelled">
            <h3>Cancelled Applications</h3>
            <div class="search">
                <input type="search" name="table-search" id="canceled-search" placeholder="What are you looking for?">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <table id="canceled-table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Grade</th>
                        <th>Contact Number</th>
                        <th>Parent Name</th>
                        <th>Parent Email</th>
                        <th>Bus Name</th>
                        <th>Bus Capacity</th>
                        <th>Morning Use</th>
                        <th>Afternoon Use</th>
                    </tr>
                </thead>
                <tbody id="canceled-table-body">
                    <!-- FETCHED DATA WILL APPEAR HERE -->
                </tbody>
            </table>
        </div>

        <div class="actions">
            <button class="daily" id="print-btn" onclick="printReport();"><i class="fa-solid fa-print"></i>Print Report</button>
            <button class="daily" id="download-btn" onclick="downloadPDF('daily');"><i class="fa-solid fa-circle-down"></i>Download PDF Report</button>
        </div>
    </section>

    <?php require(BASE_DIR . '/includes/footer.php'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="<?php echo BASE_URL . "/js/admin.js"; ?>"></script>
</body>

</html>

<?php
$conn->close();
?>