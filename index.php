<?php
$title = "Home";
include "includes/header.php";
?>

<section class="hero">
    <div>
        <h1>Online Complaint Management System</h1>
        <p>
            Submit complaints online, follow their progress,
            and help staff solve problems efficiently.
        </p>

        <?php if (isset($_SESSION["user_id"])): ?>
            <a class="button" href="user_dashboard.php">Open Dashboard</a>
        <?php else: ?>
            <a class="button" href="register.php">Get Started</a>
            <a class="button light" href="login.php">Login</a>
        <?php endif; ?>
    </div>

    <div class="simple-card">
        <h3>Two User Roles</h3>
        <p><b>Normal User:</b> Submit and track complaints.</p>
        <p><b>Staff:</b> View all complaints and update status.</p>
    </div>
</section>

<section class="three-cards">
    <div class="simple-card">
        <h3>Easy Submission</h3>
        <p>Submit a complaint with subject, category, location and description.</p>
    </div>
    <div class="simple-card">
        <h3>Status Tracking</h3>
        <p>Check whether a complaint is pending, in progress or resolved.</p>
    </div>
    <div class="simple-card">
        <h3>Staff Management</h3>
        <p>Staff can review complaints and update their status.</p>
    </div>
</section>

<?php include "includes/footer.php"; ?>
