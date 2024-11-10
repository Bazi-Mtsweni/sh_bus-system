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
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/user/bus-form.css' ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <?php
    include(BASE_DIR . "/includes/user-header.php");
    require(BASE_DIR . '/includes/alerts.php');
    ?>

    <main class="bus-selection">
        <div class="cta back">
            <a href="<?php echo BASE_URL . '/views/forms/learner-form.php'; ?>" class="btn-blue">← Go back</a>
        </div>

        <h2>Bus & Route Selection <span>(Step 2 of 2)</span></h2>

        <section class="bus-info">
            <div class="tabs flex">
                <button class="bus-tab active" data-bus="Bus1" id="bus-1">Bus 1</button>
                <button class="bus-tab" data-bus="Bus2" id="bus-2">Bus 2</button>
                <button class="bus-tab" data-bus="Bus3" id="bus-3">Bus 3</button>
            </div>
            <div class="info">
                <div class="left">
                    <h4>Morning Pickup</h4>
                    <table class="pickup">
                        <thead>
                            <tr>
                                <th>Pick up Number</th>
                                <th>Pick up Location</th>
                                <th>Pick up Time</th>
                            </tr>
                        </thead>
                        <tbody id="pickup-body">
                            <tr>
                                <td>1A</td>
                                <td>Corner of Panorama and Marabou Road</td>
                                <td>06:22</td>
                            </tr>
                            <tr>
                                <td>1B</td>
                                <td>Corner of Kolgansstraat and Skimmerstraat</td>
                                <td>06:30</td>
                            </tr>
                        </tbody>
                    </table>

                    <h4>Afternoon Dropoff</h4>
                    <table class="dropoff">
                        <thead>
                            <tr>
                                <th>Drop off Number</th>
                                <th>Drop off Location</th>
                                <th>Drop off Time</th>
                            </tr>
                        </thead>
                        <tbody id="dropoff-body">
                            <tr>
                                <td>1A</td>
                                <td>Corner of Panorama and Marabou Road</td>
                                <td>14:30</td>
                            </tr>
                            <tr>
                                <td>1B</td>
                                <td>Corner of Kolgansstraat and Skimmerstraat</td>
                                <td>14:39</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="image-container">
                    <img src="<?php echo BASE_URL . '/images/bus-1-image.webp'; ?>" alt="Image for bus number 1">
                </div>
            </div>
            <div class="bus-form">
                <div class="instructions flex">
                    <i class="fa-solid fa-circle-info"></i>
                    <p class="instruction">Please use the information provided above to make selections that will be more convenient for your child.</p>
                </div>

                <form id="bus-selection-form">
                    <div class="input">
                        <label for="bus">Bus Selection</label>
                        <select name="bus" id="bus">
                            <option value="">-- Select Bus --</option>
                            <option value="Bus1">Bus 1</option>
                            <option value="Bus2">Bus 2</option>
                            <option value="Bus3">Bus 3</option>
                        </select>
                    </div>

                    <div class="input">
                        <label for="pickup-location">Pickup Location</label>
                        <select name="pickup-location" id="pickup-location">
                            <option value="">-- Select A Bus First --</option>
                        </select>
                    </div>

                    <div class="input">
                        <label for="dropoff-location">Dropoff Location</label>
                        <select name="dropoff-location" id="dropoff-location">
                            <option value="">-- Select A Bus First --</option>
                        </select>
                    </div>

                    <div class="input time">
                        <label for="pickup-time">Pickup Time</label>
                        <input type="text" name="pickup-time" id="pickup-time" value="" readonly>
                    </div>

                    <div class="input time">
                        <label for="dropoff-time">Dropoff Time</label>
                        <input type="text" name="dropoff-time" id="dropoff-time" value="" readonly>
                    </div>

                    <div class="cta submit">
                        <p>By submitting this form you acknowledge that you have read and understood our terms and privacy policies. If not, read <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></p>
                        <button type="submit" id="submit-button" class="btn-blue">
                            <span>Submit Application</span>
                            <img id="submit-loader" class="submit-btn-loader" src="<?php echo BASE_URL . '/images/loader.gif'; ?>" alt="Button Loader" title="Loading..." style="display: none;">
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <?php require(BASE_DIR . "/includes/footer.php"); ?>

    <script type="module" src="<?php echo BASE_URL . "/js/parent-pages.js"; ?>"></script>
</body>

</html>