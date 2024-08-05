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
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/admin-reports.css' ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="">
    <?php
    include(ROOT_PATH . "/backend/controllers/dashboard-data.php");
    include(BASE_DIR . "/includes/admin-header.php");
    include(BASE_DIR . "/includes/alerts.php");
    ?>
    <h2 class="intro">Daily MIS Report - <?php echo $date; ?></h2>
    <section class="dash-nav">
        <?php include(BASE_DIR . "/includes/admin-nav.php"); ?>
        <div class="dashboard">
            <div class="actions">
                <button class="daily" onclick="printReport();"><a href="#daily-report"></a>Generate Daily Report</button>
            </div>
            <div id="daily-charts" class="charts">
                <canvas class="chart" id="buses-chart" width="100px" height="100px"></canvas>
                <canvas class="chart" id="students-chart" width="100px" height="100px"></canvas>
                <canvas class="chart" id="statuses-chart" width="100px" height="100px"></canvas>
            </div>
        </div>
    </section>

    <section class="report-table" id="daily-report">
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
        const busStudents = [];
        const approvedStudentsPerGrade = [];
        const waitingStudentsPerGrade = [];
        const canceledStudentsPerGrade = [];

        <?php foreach ($bus_capacities as $key => $capacity){ ?>
            busCapacity.push('<?php echo $capacity; ?>');
        <?php }; ?>
        <?php foreach ($total_approved_students as $bus_data){ ?>
            busStudents.push('<?php echo $bus_data["total_approved_students"]; ?>');
        <?php }; ?>
        <?php foreach (dataPerGrade($approved_students) as $total_students){ ?>
            approvedStudentsPerGrade.push('<?php echo $total_students; ?>');
        <?php }; ?>
        <?php foreach (dataPerGrade($waiting_students) as $total_students){ ?>
            waitingStudentsPerGrade.push('<?php echo $total_students; ?>');
        <?php }; ?>
        <?php foreach (dataPerGrade($canceled_students) as $total_students){ ?>
            canceledStudentsPerGrade.push('<?php echo $total_students; ?>');
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
                        data: busStudents,
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
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
                    data: approvedStudentsPerGrade,
                    borderWidth: 1,
                }, ],
            },
            options: {
                responsive: true,
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
                        data: approvedStudentsPerGrade,
                        borderWidth: 1,
                    },
                    {
                        label: "Waiting Students",
                        data: waitingStudentsPerGrade,
                        borderWidth: 1,
                    },
                    {
                        label: "Canceled Students",
                        data: canceledStudentsPerGrade,
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
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