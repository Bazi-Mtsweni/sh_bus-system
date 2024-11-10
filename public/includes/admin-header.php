<noscript>
    <style>
        html {
            display: none;
        }
    </style>
    <meta http-equiv="refresh" content="0; url=<?php echo BASE_URL . '/nojs/index.php'; ?>">
</noscript>

<?php

$sql = "SELECT * FROM notifications ORDER BY notificationId DESC LIMIT 6";
$result = $conn->query($sql);

$count_unread_sql = "SELECT COUNT(*) AS unread_count FROM notifications WHERE seen = 0";
$count_result = $conn->query($count_unread_sql);
$unread_count = $count_result->fetch_assoc()['unread_count'] ?? 0;

?>

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
        <span class="counter" id="counter"><?php echo $unread_count; ?></span>
        <i class="fa-solid fa-bell" id="dropdown-icon" data-menu="notifications"></i>
    </div>
    <div class="admin-info">
        <i class="fa-solid fa-circle-user"></i>
        <div class="info">
            <p><?php echo $initials ?></p>
            <p>Super Admin</p>
        </div>
        <i class="fa-solid fa-chevron-down" id="dropdown-icon" data-menu="admin"></i>
    </div>
    <ul class="sub-menu notifications" id="notifications">
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Each notification link has a data-id attribute for JavaScript
                echo "<li><a href='#' class='notification-item' data-id='{$row['notificationId']}'>{$row['notification']}</a></li>";
            }
        } else {
            echo "<li><a href='#'>No notifications available</a></li>";
        }
        ?>
    </ul>
    <ul class="sub-menu admin" id="admin-menu">
        <li><a href="#"><i class="fa-solid fa-circle-user"></i>Edit Profile</a></li>
        <li><a href="#"><i class="fa-solid fa-gear"></i>Settings</a></li>
        <li><a href="<?php echo BASE_URL . '/../backend/scripts/logout.php'; ?>" class="logout"><i class="fa-solid fa-right-from-bracket"></i>Sign Out</a></li>
    </ul>
    <button class="theme-btn" id="dark-mode-toggle" title="Toggle Themes">
        <span class="light"><i class="fa-solid fa-sun"></i></span>
        <span class="dark"><i class="fa-solid fa-moon"></i></span>
    </button>
</header>