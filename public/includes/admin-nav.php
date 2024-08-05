<nav class="side-nav" id="side-nav">
    <div class="title">
        <i id="sidenav-btn" class="fa-solid fa-bars" title="Menu"></i>
        <p>Menu</p>
    </div>
    <ul>
        <li>
            <i class="fa-solid fa-border-all"></i>
            <a href="<?php echo BASE_URL . '/views/admin/admin-dashboard.php'; ?>">Dashboard</a>
        </li>
        <li>
            <i class="fa-solid fa-file-lines"></i>
            <a href="#">Applications</a>
        </li>
        <li>
            <i class="fa-solid fa-chart-simple"></i>
            <a href="<?php echo BASE_URL . '/views/admin/daily-report.php'; ?>">Daily Report</a>
        </li>
        <li>
            <i class="fa-solid fa-chart-simple"></i>
            <a href="<?php echo BASE_URL . '/views/admin/weekly-report.php'; ?>">Weekly Report</a>
        </li>
        <li>
            <i class="fa-solid fa-chart-simple"></i>
            <a href="#">Monthly Report</a>
        </li>
        <li>
            <i class="fa-solid fa-user-group"></i>
            <a href="#">Manage Users</a>
        </li>
        <li class="settings">
            <i class="fa-solid fa-gear"></i>
            <a href="#">Settings</a>
        </li>
        <li>
            <i class="fa-solid fa-right-from-bracket"></i>
            <a href="<?php echo BASE_URL . '/../backend/scripts/logout.php'; ?>">Sign Out</a>
        </li>
    </ul>
</nav>