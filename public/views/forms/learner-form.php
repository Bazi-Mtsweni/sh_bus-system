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

    <title>SHSS Commute Service Appliation - Learner Details</title>

    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/user/user-styles.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/forms.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/user/learner-form.css' ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <?php
    include(BASE_DIR . "/includes/user-header.php");
    $button_text = "";
    $link = "";
    $body = "";
    $title = "Register your child for A hassle-free commute.";

    require(BASE_DIR . "/includes/hero.php");
    require(BASE_DIR . '/includes/alerts.php');
    ?>
    <div class="form-section">
        <form id="learner-form">
            <h2>Learner Details <span>(Step 1 of 2)</span></h2>

            <div class="input">
                <input type="text" name="name" id="name" placeholder="Full Name" onkeyup="validateName(this, 'name-error')" required>
                <span class="error" id="name-error"></span>
            </div>
            <div class="input">
                <input type="text" name="id" id="id" placeholder="13-Digit RSA ID Number" onkeyup="validateRSAID(this, 'id-error')" required>
                <span class="error" id="id-error"></span>
            </div>
            <div class="input">
                <select name="grade" id="grade">
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </div>
            <div class="input">
                <input type="tel" name="tel" id="tel" placeholder="Contact Number" onkeyup="validateTel(this, 'tel-error');" required>
                <span class="error" id="tel-error"></span>
            </div>
            <input type="hidden" name="bot-check" id="bot-check" aria-hidden="true">
            <div class="submit">
                <button type="submit" id="next-button" class="btn-blue">
                    <span>Next Step →</span>
                    <img id="next-loader" class="next-btn-loader" src="<?php echo BASE_URL . '/images/loader.gif'; ?>" alt="Button Loader" title="Loading..." style="display: none;">
                </button>
            </div>
        </form>
    </div>

    <?php require(BASE_DIR . "/includes/footer.php"); ?>

    <script type="module" src="<?php echo BASE_URL . "/js/parent-pages.js"; ?>"></script>
</body>

</html>