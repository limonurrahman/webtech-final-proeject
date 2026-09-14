<?php
include "includes/auth.php";
requireRole("staff");
include "config/db.php";

function countComplaints($conn, $status = "") {
    if ($status == "") {
        $result = $conn->query("SELECT COUNT(*) AS total FROM complaints");
    } else {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM complaints WHERE status = ?");
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $result = $stmt->get_result();
    }

    $row = $result->fetch_assoc();
    return $row["total"];
}

$total = countComplaints($conn);
$pending = countComplaints($conn, "Pending");
$progress = countComplaints($conn, "In Progress");
$resolved = countComplaints($conn, "Resolved");

$title = "Staff Dashboard";
include "includes/header.php";
?>

<div class="dashboard-title">
    <div>
        <h1>Staff Dashboard</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION["name"]); ?></p>
    </div>
    <a class="button" href="all_complaints.php">View All Complaints</a>
</div>

<section class="stats">
    <div><span>Total Complaints</span><b><?php echo $total; ?></b></div>
    <div><span>Pending</span><b><?php echo $pending; ?></b></div>
    <div><span>In Progress</span><b><?php echo $progress; ?></b></div>
    <div><span>Resolved</span><b><?php echo $resolved; ?></b></div>
</section>

<section class="panel">
    <h2>Staff Responsibilities</h2>
    <ul>
        <li>Review submitted complaints.</li>
        <li>Check complaint details.</li>
        <li>Change complaint status.</li>
        <li>Resolve complaints and keep records updated.</li>
    </ul>
    <a class="button" href="all_complaints.php">Manage Complaints</a>
</section>

<?php include "includes/footer.php"; ?>
