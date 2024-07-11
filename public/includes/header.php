<header>
    <div class="image-container">
        <img id="logo" src="<?php echo BASE_URL . '/images/logo.svg'; ?>" alt="Strive High Logo">
    </div>
    <div class="nav-info">
        <div class="info">
            <div class="details office-hours">
                <i class="fa-solid fa-clock"></i>
                <div class="info-text">
                    <h3>Office Hours</h3>
                    <p>Mon-Fri: 8am - 4pm</p>
                </div>
            </div>
            <div class="details tel-number">
                <i class="fa-solid fa-phone"></i>
                <div class="info-text">
                    <h3>Need Assistance?</h3>
                    <p>+27 (0) 81 319 9670</p>
                </div>
            </div>
            <div class="details email-address">
                <i class="fa-solid fa-envelope"></i>
                <div class="info-text">
                    <h3>Have A Query?</h3>
                    <p>info@strivehigh.co.za</p>
                </div>
            </div>
            <button class="theme-btn" id="dark-mode-toggle" title="Toggle Themes">
                <span class="light"><i class="fa-solid fa-sun"></i></span>
                <span class="dark"><i class="fa-solid fa-moon"></i></span>
            </button>
        </div>
        <nav class="nav">
            <ul class="menu">
                <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
                <li><a href="#">About Strive High</a></li>
                <li><a href="#">Academics</a><i id="dropdown-icon" data-menu="academics" class="fa-solid fa-chevron-down"></i></li>
                <li><a href="#">Apply</a><i id="dropdown-icon" data-menu="apply" class="fa-solid fa-chevron-down"></i></li>
                <li><a href="#">School Fees</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
            <ul class="sub-menu academics" id="academics-menu">
                <li><a href="#">Our Research Staff</a></li>
                <li><a href="#">Offered Subjects</a></li>
                <li><a href="#">2024 School Calendar</a></li>
                <li><a href="#">Our Qualified Teachers</a></li>
            </ul>
            <ul class="sub-menu apply" id="apply-menu">
                <li><a href="#">Apply For The 2025 Academic Year</a></li>
                <li><a href="<?php echo BASE_URL . '/views/forms/signup-form.php'; ?>">Apply For Bus Transportation - 2025 </a></li>
                <li><a href="#">Apply For School Governing Body</a></li>
                <li><a href="#">Apply For Sports Teams</a></li>
            </ul>
            <div class="cta">
                <a href="<?php echo BASE_URL . '/views/forms/signup-form.php' ?>" class="btn-secondary register">Register</a>
                <a href="<?php echo BASE_URL . '/views/forms/login-form.php' ?>" class="btn-green login">Login</a>
            </div>
        </nav>
    </div>
</header>