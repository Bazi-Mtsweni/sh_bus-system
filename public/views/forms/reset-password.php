<?php
ob_start();
define('BASE_DIR', realpath(dirname(__FILE__) . '/../..'));
require(BASE_DIR . '/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strive High Secondary School - Reset Password</title>

    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/styles.css'; ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/forms.css'; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>

<body>
    <?php require(BASE_DIR . '/includes/header.php'); ?>
    <?php require(BASE_DIR . '/includes/alerts.php'); ?>

    <div class="form-section" style="margin: 3rem auto;">
        <form id="p-request">
            <h2 style="text-align: center;">Reset Your Password</h2>
            <p style="margin: 2rem 0; line-height: 1.4rem;">You have requested to reset your password. Please enter your email address so we can send you a password reset link. If this was a mistake, please return to the <a href="./login-form.php">login</a> page.</p>
            <div class="input">
                <input type="email" name="email" id="email" placeholder="Enter Your Email Address" onkeyup="validateEmail(this, 'email-error');" required>
                <span class="error" id="email-error"></span>
            </div>
            <input type="hidden" name="bot-check" id="bot-check" aria-hidden="true">
            <button type="submit" id="p-request-submit" class="btn-blue" style="cursor: pointer;">
                <span>Send Reset Link</span>
                <img id="p-request-loader" class="submit-btn-loader" src="<?php echo BASE_URL . '/images/loader.gif'; ?>" alt="Button Loader" title="Loading..." style="display: none; margin-left:1rem;">
            </button>
        </form>
    </div>

    <?php require(BASE_DIR . '/includes/footer.php'); ?>

    <script type="module" src="<?php echo BASE_URL . '/js/pass-reset.js'; ?>"></script>
</body>

</html>