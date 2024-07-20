<?php
    define('BASE_DIR', realpath(dirname(__FILE__) . '/../..'));
    require(BASE_DIR . '/config.php');

    $username = "Kgotso Mtsweni";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Strive High Secondary School - Parents Login</title>

    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/user/user-styles.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/user/dashboard.css' ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <?php include(BASE_DIR . "/includes/user-header.php"); ?>

    <?php 
        $button_text = "Apply For Your Child";
        $link = "../forms/learner-form.php";
        $title = "Convenient and Safe Transportation for All Students";
        $body = "Strive High Secondary School introduces a new bus registration system designed to ensure safe and efficient transportation for our learners. Sign up today to secure a seat for your child next year.";
        require(BASE_DIR . "/includes/hero.php"); 
    ?>

    <main>
        <div class="registration-info">
            <div class="information">
                <h2>Bus Registration System 2025</h2>
                <div class="text">
                    <p>At Strive High Secondary School, we prioritize the safety and convenience of our students by offering reliable bus transportation to and from school. To ensure a smooth and efficient process for the upcoming school year, we have outlined the following important information for both current and new learners regarding bus registration.</p>
                    <p><strong>Current Learners:</strong> If your child is already registered to ride our school buses, it is essential to re-register early to secure their spot for the next school year. Re-registration must be completed before or on 1 November 2024. This early registration helps us plan and allocate resources effectively to accommodate all students.</p>
                    <p><strong>New Learners:</strong> For new learners joining Strive High Secondary School, registering for the bus service early is crucial. Registration must be completed before or on 1 November 2024 to ensure a place on one of our buses. Early registration allows us to finalize routes and schedules to best serve our student community.</p>
                    <p><strong>Registration Process:</strong> To register, parents or guardians need to fill out the bus registration form completely and submit it to the administrative office. It is important to ensure that all sections of the form are accurately filled out to avoid any delays in processing.</p>
                    <p><strong>Bus Service Details:</strong>
                        <ul class="lv1">
                            <li>Our buses will begin running from the first day of school in the new school year, ensuring that all students have a reliable means of transportation right from the start.</li>
                            <li>Due to traffic pressures or weather conditions, bus times may shift approximately 10 minutes earlier or later. We advise parents and students to plan accordingly and stay informed of any updates.</li>
                            <li>The bus service will cater to students in the following locations:
                                <ul class="lv2">
                                    <li>Rooihuiskraal</li>
                                    <li>Wierdapark</li>
                                    <li>Centurion</li>
                                </ul>
                            </li>
                        </ul>
                    </p>
                    <p>By providing comprehensive and reliable bus services, Strive High Secondary School aims to support our students' punctuality and attendance, making their school experience as stress-free as possible. For any questions or additional information regarding the bus registration process, please contact our administrative office. We look forward to serving your transportation needs in the upcoming school year.</p>
                </div>
                <a href="../forms/learner-form.php" class="btn-gold">Enroll Your Child Now!</a>
            </div>
            <div class="image-conatainer">
                <img src="<?php echo BASE_URL. '/images/bus-seats.png';?>" alt="Bus Seats">
            </div>
        </div>
        <div class="news">
            <h2>Strive High News & Updates</h2>
            <div class="cards">
                <div class="card">
                    <div class="image-container">
                        <img src="<?php echo BASE_URL. '/images/article-img-1.png';?>" alt="School Kids">
                    </div>
                    <h3>Strive High Secondary School Hosts Annual Sports Day</h3>
                    <p>Strive High Secondary School recently hosted its annual Sports Day, bringing together students, staff, and families for a day of fun and competition...</p>
                    <a href="#">Read more ></a>
                </div>
                <div class="card">
                    <div class="image-container">
                        <img src="<?php echo BASE_URL. '/images/article-img-2.png';?>" alt="Busses">
                    </div>
                    <h3>New Bus Registration System Launched for 2025</h3>
                    <p>In an effort to streamline transportation services, Strive High Secondary School has launched a new bus registration system for the 2024 school year...</p>
                    <a href="#">Read more ></a>
                </div>
                <div class="card">
                    <div class="image-container">
                        <img src="<?php echo BASE_URL. '/images/article-img-3.png';?>" alt="Exam Paper">
                    </div>
                    <h3>Strive High Achieves 100% Pass Rate for 2023/24 Matric Results</h3>
                    <p>Strive High Secondary School is proud to announce an impressive 100% pass rate for the recent academic year. This achievement reflects the dedication...</p>
                    <a href="#">Read more ></a>
                </div>
            </div>
        </div>
    </main>

    <?php require(BASE_DIR . "/includes/footer.php"); ?>

    <script src="<?php echo BASE_URL . "/js/parent-pages.js"; ?>"></script>
</body>

</html>