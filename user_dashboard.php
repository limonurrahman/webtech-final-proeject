<?php
include "includes/auth.php";
requireRole("user");
include "config/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = trim($_POST["subject"]);
    $category = trim($_POST["category"]);
    $location = trim($_POST["location"]);
    $description = trim($_POST["description"]);
    $user_id = $_SESSION["user_id"];

    if ($subject == "" || $category == "" || $location == "" || $description == "") {
        $message = "Please fill in every field.";
    } else {
        $sql = "INSERT INTO complaints
                (user_id, subject, category, location, description)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $user_id, $subject, $category, $location, $description);
        $stmt->execute();

        $message = "Complaint submitted successfully.";
    }
}

$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM complaints WHERE user_id = ? ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$complaints = $stmt->get_result();

$total = 0;
$pending = 0;
$progress = 0;
$resolved = 0;

while ($row = $complaints->fetch_assoc()) {
    $total++;
    if ($row["status"] == "Pending") $pending++;
    if ($row["status"] == "In Progress") $progress++;
    if ($row["status"] == "Resolved") $resolved++;
    $rows[] = $row;
}

$title = "User Dashboard";
include "includes/header.php";
?>

<div class="dashboard-title">
    <div>
        <h1>User Dashboard</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION["name"]); ?></p>
    </div>
    <a class="button light" href="profile.php">My Profile</a>
</div>

<?php if ($message != ""): ?>
    <p class="success"><?php echo $message; ?></p>
<?php endif; ?>

<section class="stats">
    <div><span>Total Complaints</span><b><?php echo $total; ?></b></div>
    <div><span>Pending</span><b><?php echo $pending; ?></b></div>
    <div><span>In Progress</span><b><?php echo $progress; ?></b></div>
    <div><span>Resolved</span><b><?php echo $resolved; ?></b></div>
</section>

<section class="panel">
    <h2>Submit Complaint</h2>

    <form method="post" onsubmit="return validateComplaint()">
        <label>Subject</label>
        <input type="text" name="subject" id="subject" required>

        <label>Category</label>
        <select name="category" required>
            <option value="">Select Category</option>
            <option>Service</option>
            <option>Infrastructure</option>
            <option>Staff Behavior</option>
            <option>Technical Issue</option>
            <option>Other</option>
        </select>

        <label>Location</label>
        <input type="text" name="location" required>

        <label>Description</label>
        <textarea name="description" id="description" rows="5" required></textarea>

        <p id="complaintError" class="error"></p>
        <button class="button" type="submit">Submit Complaint</button>
    </form>
</section>

<section class="panel">
    <h2>My Complaints</h2>

    <div class="table-box">
        <table>
            <tr>
                <th>ID</th>
                <th>Subject</th>
                <th>Category</th>
                <th>Location</th>
                <th>Status</th>
                <th>Date</th>
            </tr>

            <?php if (!empty($rows)): ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo htmlspecialchars($row["subject"]); ?></td>
                        <td><?php echo htmlspecialchars($row["category"]); ?></td>
                        <td><?php echo htmlspecialchars($row["location"]); ?></td>
                        <td><span class="status"><?php echo $row["status"]; ?></span></td>
                        <td><?php echo date("Y-m-d", strtotime($row["created_at"])); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No complaints submitted yet.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</section>

<script src="assets/js/validation.js"></script>
<?php include "includes/footer.php"; ?>
