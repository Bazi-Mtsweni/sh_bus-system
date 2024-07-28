<noscript>
  <style>html{display:none;}</style>
  <meta http-equiv="refresh" content="0; url=<?php echo BASE_URL .'/nojs/index.php';?>">
</noscript>

<header>
    <div class="logo">
        <h1>Admin Panel</h1>
    </div>
    <div class="search">
        <div class="input">
            <input type="text" name="search" id="search" placeholder="What are you looking for?">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
    </div>
    <div class="notifications">
        <span class="counter" id="counter">5</span>
        <i class="fa-solid fa-bell" id="dropdown-icon" data-menu="notifications"></i>
    </div>
    <div class="admin-info">
        <i class="fa-solid fa-circle-user"></i>
        <div class="info">
            <p><?php echo $initials?></p>
            <p>Super Admin</p>
        </div>
        <i class="fa-solid fa-chevron-down" id="dropdown-icon" data-menu="admin"></i>
    </div>
    <ul class="sub-menu notifications" id="notifications">
        <li><a href="#">Thabiso has applied</a></li>
        <li><a href="#">Bus A is full</a></li>
        <li><a href="#">Bus B is full</a></li>
        <li><a href="#">New learner waiting</a></li>
    </ul>
    <ul class="sub-menu admin" id="admin-menu">
        <li><a href="#"><i class="fa-solid fa-circle-user"></i>Edit Profile</a></li>
        <li><a href="#"><i class="fa-solid fa-gear"></i>Settings</a></li>
        <li><a href="<?php echo BASE_URL. '/../backend/scripts/logout.php';?>" class="logout"><i class="fa-solid fa-right-from-bracket"></i>Sign Out</a></li>
    </ul>
    <button class="theme-btn" id="dark-mode-toggle" title="Toggle Themes">
        <span class="light"><i class="fa-solid fa-sun"></i></span>
        <span class="dark"><i class="fa-solid fa-moon"></i></span>
    </button>
</header>