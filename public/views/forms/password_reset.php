<?php
ob_start();
define('BASE_DIR', realpath(dirname(__FILE__) . '/../..'));

require(BASE_DIR . '/config.php');
require(ROOT_PATH ."/backend/db/conn.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strive High Secondary School - Update Password</title>

    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/styles.css'; ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/forms.css'; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php require(BASE_DIR . '/includes/header.php'); ?>
    <?php require(BASE_DIR . '/includes/alerts.php'); ?>


    <?php

    // Verify the token and email
    if (isset($_GET['token']) && isset($_GET['email'])) {
        $token = $_GET['token'];
        $email = $_GET['email'];

        $stmt = $conn->prepare("SELECT expires_at FROM password_resets WHERE email = ? AND token = ?");
        $stmt->bind_param("ss", $email, $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (time() < $row['expires_at']) {
                // Token is valid, display the reset form
    ?>
                <div class="form-section" style="margin: 3rem auto;" >
                    <form id="p-reset">
                        <h2 style="text-align: center; margin-bottom: 2rem;">Reset Your Password</h2>
                        <div class="input">
                            <input type="password" name="password" id="password" placeholder="Enter Your New Password" onkeyup="validateLoginPassword(this, 'password-error');" required>
                            <span class="error" id="password-error"></span>
                            <i class="fa-solid fa-eye" id="eyeIcon" title="Show Password"></i>
                        </div>
                        <input type="hidden" name="bot-check" id="bot-check" aria-hidden="true">
                        <button type="submit" id="p-reset-submit" class="btn-blue">
                            <span>Reset Password</span>
                            <img id="p-reset-loader" class="submit-btn-loader" src="<?php echo BASE_URL . '/images/loader.gif'; ?>" alt="Button Loader" title="Loading..." style="display: none;">
                        </button>
                    </form>
                </div>
    <?php
            } else {
                echo "<strong><p style='margin: 2rem 0; padding-left: 5%; font-size: 1.5rem;'>The reset link has expired.</p></strong>";
            }
        } else {
            echo "<strong><p style='margin: 2rem 0; padding-left: 5%; font-size: 1.5rem;'>Invalid token or email.</p></strong>";
        }
    } else {
        echo "<strong><p style='margin: 2rem 0; padding-left: 5%; font-size: 1.5rem;'>Invalid request.</p></strong>";
    }
    ?>

    <?php require(BASE_DIR . '/includes/footer.php'); ?>

    <script type="module" src="<?php echo BASE_URL . '/js/pass-reset.js'; ?>"></script>
</body>

</html>