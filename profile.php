<?php
include "includes/auth.php";
requireLogin();
include "config/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);

    if ($name != "") {
        $stmt = $conn->prepare("UPDATE users SET name=? WHERE id=?");
        $stmt->bind_param("si", $name, $_SESSION["user_id"]);
        $stmt->execute();
        $_SESSION["name"] = $name;
        $message = "Profile updated.";
    }
}

$title = "Profile";
include "includes/header.php";
?>

<div class="form-card">
    <h2>My Profile</h2>

    <?php if ($message != ""): ?>
        <p class="success"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($_SESSION["name"]); ?>" required>

        <label>Email</label>
        <input type="email" value="<?php echo htmlspecialchars($_SESSION["email"]); ?>" disabled>

        <label>Role</label>
        <input value="<?php echo htmlspecialchars($_SESSION["role"]); ?>" disabled>

        <button class="button" type="submit">Save Changes</button>
    </form>
</div>

<?php include "includes/footer.php"; ?>
