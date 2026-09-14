<?php
include "includes/auth.php";
requireRole("staff");
include "config/db.php";

$sql = "SELECT complaints.*, users.name, users.email
        FROM complaints
        JOIN users ON complaints.user_id = users.id
        ORDER BY complaints.id DESC";

$result = $conn->query($sql);

$title = "All Complaints";
include "includes/header.php";
?>

<div class="dashboard-title">
    <div>
        <h1>All Complaints</h1>
        <p>Staff can review and update every complaint.</p>
    </div>
</div>

<section class="panel">
    <div class="table-box">
        <table>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Complaint</th>
                <th>Details</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td>
                        <?php echo htmlspecialchars($row["name"]); ?><br>
                        <small><?php echo htmlspecialchars($row["email"]); ?></small>
                    </td>
                    <td>
                        <b><?php echo htmlspecialchars($row["subject"]); ?></b><br>
                        <?php echo htmlspecialchars($row["category"]); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($row["location"]); ?><br>
                        <?php echo htmlspecialchars($row["description"]); ?>
                    </td>
                    <td>
                        <span class="status"><?php echo $row["status"]; ?></span>
                    </td>
                    <td>
                        <select onchange="updateStatus(<?php echo $row['id']; ?>, this.value)">
                            <option <?php if ($row["status"]=="Pending") echo "selected"; ?>>Pending</option>
                            <option <?php if ($row["status"]=="In Progress") echo "selected"; ?>>In Progress</option>
                            <option <?php if ($row["status"]=="Resolved") echo "selected"; ?>>Resolved</option>
                        </select>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <p id="statusMessage" class="success"></p>
</section>

<script src="assets/js/staff.js"></script>
<?php include "includes/footer.php"; ?>
