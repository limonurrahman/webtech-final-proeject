<?php
include "config/db.php";
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["name"] = $user["name"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["role"] = $user["role"];

        if ($user["role"] == "staff") {
            header("Location: staff_dashboard.php");
        } else {
            header("Location: user_dashboard.php");
        }
        exit();
    } else {
        $message = "Invalid email or password.";
    }
}

$title = "Login";
include "includes/header.php";
?>

<div class="form-card">
    <h2>Login</h2>

    <?php if (isset($_GET["registered"])): ?>
        <p class="success">Registration successful. Please log in.</p>
    <?php endif; ?>

    <?php if ($message != ""): ?>
        <p class="error"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button class="button" type="submit">Login</button>
    </form>

    <p>New user? <a href="register.php">Register here</a></p>
</div>

<?php include "includes/footer.php"; ?>
