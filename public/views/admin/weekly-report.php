<?php

define('BASE_DIR', realpath(dirname(__FILE__) . '/../..'));

require(BASE_DIR . '/config.php');
require(ROOT_PATH . '/backend/controllers/weekly-report.php');

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

    <title>Weekly Reports - SHSS Admin</title>

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
    <h2 class="intro">Weekly MIS Report - <?php echo "From ". $days[0] ; ?></h2>
    <section class="dash-nav">
        <?php include(BASE_DIR . "/includes/admin-nav.php"); ?>
        <div class="dashboard">
            <div class="actions">
                <button class="weekly" onclick="printReport();"><a href="#daily-report"></a>Generate Weekly Report</button>
            </div>
            <div id="weekly-charts" class="charts">
                <canvas class="chart" id="weeklyReportChart"></canvas>
            </div>
            <div id="weekly-charts" class="charts">
                <canvas class="chart pie" id="approvedStudentsPieChart"></canvas>
                <canvas class="chart" id="busUsageChart"></canvas>
            </div>
        </div>
    </section>

    <section class="report-table" id="weekly-report">
        <h2>Weekly Report - <?php echo "From ". $days[0] . " to " . $days[6]; ?></h2>
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
                        <th>Reg. Date</th>
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
                        <th>Reg. Date</th>
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
                        <th>Reg. Date</th>
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
        const ctx = document.getElementById('weeklyReportChart').getContext('2d');
        const pieCtx = document.getElementById('approvedStudentsPieChart').getContext('2d');
        const busUsageCtx = document.getElementById('busUsageChart').getContext('2d');

        const weeklyReportChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($days); ?>,
                datasets: [{
                        label: 'Approved Students',
                        data: <?php echo json_encode($approvedStudents); ?>,
                        backgroundColor: 'rgba(75, 192, 192, 1)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Waiting Students',
                        data: <?php echo json_encode($waitingStudents); ?>,
                        backgroundColor: 'rgba(255, 159, 64, 1)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                plugins: {
                    title: {
                        text: "Weekly Charts Of Registered Students",
                        display: true
                    }
                },
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            text: "Dates For The Past 7 Days",
                            display: true
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            text: "Number Of Registrations",
                            display: true
                        }
                    }
                }
            }
        });

        const approvedStudentsPieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ["Grade 8", "Grade 9", "Grade 10", "Grade 11", "Grade 12"],
                datasets: [{
                    data: <?php echo json_encode($approvedStudentsPerGrade); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        text: "Approved Students Per Grade - Last 7 Days",
                        display: true 
                    }  
                }
            }
        });

        const busUsageChart = new Chart(busUsageCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($busNames); ?>,
                datasets: [
                    {
                        label: 'Morning Use',
                        data: <?php echo json_encode($morningUse); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 1)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Afternoon Use',
                        data: <?php echo json_encode($afternoonUse); ?>,
                        backgroundColor: 'rgba(255, 206, 86, 1)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        text: "Bus Usage By Students - Last 7 Days",
                        display: true 
                    }  
                }
            }
        });
    </script>
</body>

</html>

<?php
$conn->close();
?>