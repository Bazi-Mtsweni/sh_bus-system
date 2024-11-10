<noscript>
    <style>
        html {
            display: none;
        }
    </style>
    <meta http-equiv="refresh" content="0; url=<?php echo BASE_URL . '/nojs/index.php'; ?>">
</noscript>

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
                <li><a href="<?php echo BASE_URL . '/views/user/user-dashboard.php'; ?>">Dashboard</a></li>
                <li><a href="<?php echo BASE_URL . '/views/forms/learner-form.php'; ?>">Start New Application</a></li>
                <li><a href="<?php echo BASE_URL . '/views/user/application-status.php'; ?>">View Application Status</a></li>
            </ul>
            <div class="user-info">
                <i class="fa-solid fa-circle-user"></i>
                <div class="info">
                    <p><?php echo $username; ?></p>
                </div>
                <i class="fa-solid fa-chevron-down" id="dropdown-icon" data-menu="user"></i>
            </div>
            <ul class="sub-menu user" id="user-menu">
                <li><a href="#"><i class="fa-solid fa-circle-user"></i>Edit Profile</a></li>
                <li><a href="#"><i class="fa-solid fa-gear"></i>Settings</a></li>
                <li><a href="<?php echo BASE_URL . '/../backend/scripts/logout.php'; ?>" class="logout"><i class="fa-solid fa-right-from-bracket"></i>Sign Out</a></li>
            </ul>
        </nav>
    </div>
</header>