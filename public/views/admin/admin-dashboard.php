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

    <?php require(BASE_DIR . '/includes/footer.php'); ?>

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