<?php
function display_alerts() {
    if (isset($_SESSION['error'])) {
        echo "<div class='alert error'>{$_SESSION['error']}</div>";
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo "<div class='alert success'>{$_SESSION['success']}</div>";
        unset($_SESSION['success']);
    }
}
?>

<header>
    <nav>
        <div class="logo"><a href="index.php">EduConnect</a></div>
        <ul class="nav-links">
            <li><a href="courses.php">Courses</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php" class="cta-button">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
