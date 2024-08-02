<?php

define('BASE_DIR', realpath(dirname(__FILE__) . '/../..'));

require(BASE_DIR . '/config.php');
require(ROOT_PATH . '/backend/db/conn.php');

if (!isset($_SESSION["admin_id"])) {
    header("Location: http://localhost/sh-bus-system/public");
}

$initials = $_SESSION["initials"];
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
    <?php
    include(ROOT_PATH . "/backend/controllers/dashboard-data.php");
    include(BASE_DIR . "/includes/admin-header.php");
    include(BASE_DIR . "/includes/alerts.php");
    ?>
    <h2 class="intro">Welcome to admin, <?php echo $initials ?></h2>
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
                    <h3><?php echo $initials ?></h3>
                    <p>Super Admin</p>
                    <a href="#" class="button">Manage Profile</a>
                </div>
                <div class="card applications">
                    <span class="bg"></span>
                    <div class="icon">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <h3>Total Applications</h3>
                    <p><?php echo $all_applications; ?></p>
                    <a href="#" class="button">View Applications</a>
                </div>
            </div>
            <div id="daily-charts" class="charts">
                <canvas class="chart" id="buses-chart" width="100px" height="100px"></canvas>
                <canvas class="chart" id="students-chart" width="100px" height="100px"></canvas>
                <canvas class="chart" id="statuses-chart" width="100px" height="100px"></canvas>
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
                        <th>Bus Name</th>
                        <th>Morning Use</th>
                        <th>Afternoon Use</th>
                        <th class="table-actions">Actions</th>
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
                        <th>Bus Name</th>
                        <th>Morning Use</th>
                        <th>Afternoon Use</th>
                        <th class="table-actions">Actions</th>
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
                        <th>Bus Name</th>
                        <th>Morning Use</th>
                        <th>Afternoon Use</th>
                        <th class="table-actions">Actions</th>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?php echo BASE_URL . "/js/admin.js"; ?>"></script>
    <script>
        // Graphs

        const buses = document.getElementById("buses-chart");
        const students = document.getElementById("students-chart");
        const statuses = document.getElementById("statuses-chart");

        const busCapacity = [];
        <?php foreach ($bus_capacities as $key => $capacity){ ?>
            busCapacity.push('<?php echo $capacity; ?>');
        <?php }; ?>

        new Chart(buses, {
            type: "bar",
            data: {
                labels: ["Bus 1", "Bus 2", "Bus 3"],
                datasets: [{
                        label: "Bus Capacity",
                        data: busCapacity,
                        borderWidth: 1,
                    },
                    {
                        label: "Number of Students",
                        data: [22, 4, 13],
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
                plugins: {
                    title: {
                        display: true,
                        text: "Total Number Of Students Per Bus",
                    },
                },
            },
        });

        new Chart(students, {
            type: "pie",
            data: {
                labels: ["Grade 8", "Grade 9", "Grade 10", "Grade 11", "Grade 12"],
                datasets: [{
                    label: "Students Using The Bus",
                    data: [20, 8, 15, 10, 5],
                    borderWidth: 1,
                }, ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
                plugins: {
                    title: {
                        display: true,
                        text: "Approved Students per Grade",
                    },
                },
            },
        });

        new Chart(statuses, {
            type: "line",
            data: {
                labels: ["Grade 8", "Grade 9", "Grade 10", "Grade 11", "Grade 12"],
                datasets: [{
                        label: "Approved Students",
                        data: [10, 2, 5, 8, 5],
                        borderWidth: 1,
                    },
                    {
                        label: "Waiting Students",
                        data: [9, 6, 2, 2, 0],
                        borderWidth: 1,
                    },
                    {
                        label: "Canceled Students",
                        data: [1, 0, 8, 0, 0],
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
                plugins: {
                    title: {
                        display: true,
                        text: "Student Statuses Per Grade",
                    },
                },
            },
        });
    </script>
</body>

</html>

<?php
$conn->close();
?>