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
    <title>Strive High Secondary School - Register</title>

    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/styles.css'; ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/forms.css'; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="dar">
    <?php require(BASE_DIR . '/includes/header.php'); ?>

    <main>
        <div class="image-container">
            <img src="<?php echo BASE_URL . '/images/student.png'; ?>" alt="Shool Kids">
        </div>
        <div class="form-section">
            <form action="">
                <h2>Register An Account</h2>
                <div class="input">
                    <select name="title" id="title">
                        <option value="mr">Mr.</option>
                        <option value="ms">Ms.</option>
                        <option value="mrs">Mrs.</option>
                        <option value="dr">Dr.</option>
                        <option value="prof">Prof.</option>
                    </select>
                </div>
                <div class="input">
                    <input type="text" name="name" id="name" placeholder="Full Name" onkeyup="validateName(this, 'name-error')" required>
                    <span class="error" id="name-error"></span>
                </div>
                <div class="input">
                    <input type="text" name="id" id="id" placeholder="13-Digit RSA ID Number" onkeyup="validateRSAID(this, 'id-error')" required>
                    <span class="error" id="id-error"></span>
                </div>
                <div class="input">
                    <input type="text" name="username" id="username" placeholder="Username" onkeyup="validateUsername(this, 'username-error');" required>
                    <span class="error" id="username-error"></span>
                </div>
                <div class="input">
                    <input type="email" name="email" id="email" placeholder="Email" onkeyup="validateEmail(this, 'email-error');" required>
                    <span class="error" id="email-error"></span>
                </div>
                <div class="input">
                    <input type="tel" name="tel" id="tel" placeholder="Contact Number" onkeyup="validateTel(this, 'tel-error');" required>
                    <span class="error" id="tel-error"></span>
                </div>
                <div class="input">
                    <input type="password" name="password" id="password" placeholder="Choose A Password" onkeyup="validatePassword(this, 'password-error');" required>
                    <span class="error" id="password-error"></span>
                    <i class="fa-solid fa-eye" id="eyeIcon" title="Show Password"></i>
                </div>
                <div class="conditions">
                    <p id="uppercase-condition">Have at least 1 uppercase character<i id="uppercase-icon" class="fa-solid fa-circle-xmark" style="margin-left: 0.5rem;"></i></p>
                    <p id="lowercase-condition">Have at least 1 lowercase character<i id="lowercase-icon" class="fa-solid fa-circle-xmark" style="margin-left: 0.5rem;"></i></p>
                    <p id="specialchar-condition">Have at least 1 special character<i id="specialchar-icon" class="fa-solid fa-circle-xmark" style="margin-left: 0.5rem;"></i></p>
                    <p id="number-condition">Have at least 1 number<i id="number-icon" class="fa-solid fa-circle-xmark" style="margin-left: 0.5rem;"></i></p>
                    <p id="length-condition">Have at least 8 characters<i id="length-icon" class="fa-solid fa-circle-xmark" style="margin-left: 0.5rem;"></i></p>
                </div>
                <div class="input">
                    <input type="password" name="password-2" id="password-2" placeholder="Repeat Password" onkeyup="matchPasswords(this, 'password-2-error');" required>
                    <span class="error" id="password-2-error"></span>
                </div>
                <div class="submit">
                    <p>Already have an account? <a href="./login-form.php">Login</a></p>
                    <button type="submit" id="login-submit" class="btn-blue">
                        <span>Submit</span>
                        <img id="contact-loader" class="submit-btn-loader" src="<?php echo BASE_URL . '/images/loader.gif'; ?>" alt="Button Loader" title="Loading..." style="display: none;">
                    </button>
                </div>
            </form>
        </div>
    </main>

    <?php require(BASE_DIR . '/includes/footer.php'); ?>


    <script type="module" src="<?php echo BASE_URL . '/js/index.js'; ?>"></script>
</body>

</html>