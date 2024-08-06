<?php
ob_start();
define('BASE_DIR', realpath(dirname(__FILE__) . '/../..'));
require(BASE_DIR .'/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strive High Secondary School - Admin Login</title>

    <link rel="stylesheet" href="<?php echo BASE_URL.'/css/styles.css';?>">
    <link rel="stylesheet" href="<?php echo BASE_URL.'/css/forms.css';?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body class="dar">
    <?php require(BASE_DIR. '/includes/header.php'); ?>
    <?php require(BASE_DIR. '/includes/alerts.php'); ?>

    <main>
        <div class="image-container">
            <img src="<?php echo BASE_URL.'/images/office-chair.webp';?>" alt="Shool Kids">
        </div>
        <div class="form-section">
            <form id="admin-form">
                <div class="selector">
                    <a href="./admin-form.php" class="current">Admin</a>
                    <a href="./login-form.php">Parent</a>
                </div>
                <h2>Admin Portal Log In.</h2>
                <div class="input">
                    <input type="text" name="initials" id="initials" placeholder="Admin Initials" onkeyup="validateInitials(this, 'initials-error');" required >
                    <span class="error" id="initials-error"></span>
                </div>
                <div class="input">
                    <input type="email" name="email" id="email" placeholder="Email Address" onkeyup="validateEmail(this, 'email-error');" required >
                    <span class="error" id="email-error"></span>
                </div>
                <div class="input">
                    <input type="password" name="password" id="password" placeholder="Password" onkeyup="validateLoginPassword(this, 'password-error');" required>
                    <span class="error" id="password-error"></span>
                    <i class="fa-solid fa-eye" id="eyeIcon" title="Show Password"></i>
                </div>
                <p>Forgot Your Password? <a href="#">Reset Password</a></p>
                <!-- <div class="input">
                    <input type="text" name="admin-id" id="admin-id" placeholder="Admin ID" onkeyup="validateAdminID(this, 'admin-id-error');" required>
                    <span class="error" id="admin-id-error"></span>
                </div> -->
                <input type="hidden" aria-hidden="true" name="admin-id" id="admin-id" value="ICT3715" required>
                <input type="hidden" name="bot-check" id="bot-check" aria-hidden="true">
                <div class="submit">
                    <button type="submit" id="admin-submit" class="btn-blue">
                        <span>Submit</span>
                        <img id="admin-loader" class="submit-btn-loader" src="<?php echo BASE_URL. '/images/loader.gif'; ?>" alt="Button Loader" title="Loading..." style="display: none;">
                    </button>
                </div>
            </form>
        </div>
    </main>

    <?php require(BASE_DIR. '/includes/footer.php'); ?>


    <script type="module" src="<?php echo BASE_URL. '/js/index.js';?>"></script>
</body>
</html>