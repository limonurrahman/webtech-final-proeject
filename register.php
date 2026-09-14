<?php
include "config/db.php";
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if ($name == "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid name and email.";
    } elseif (strlen($password) < 6) {
        $message = "Password must contain at least 6 characters.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            header("Location: login.php?registered=1");
            exit();
        } else {
            $message = "Email already exists or registration failed.";
        }
    }
}

$title = "Register";
include "includes/header.php";
?>

<div class="form-card">
    <h2>Create Account</h2>

    <?php if ($message != ""): ?>
        <p class="error"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post" onsubmit="return validateRegister()">
        <label>Name</label>
        <input type="text" name="name" id="name" required>

        <label>Email</label>
        <input type="email" name="email" id="email" required>

        <label>Password</label>
        <input type="password" name="password" id="password" required>

        <p id="formError" class="error"></p>

        <button class="button" type="submit">Register</button>
    </form>

    <p>Already registered? <a href="login.php">Login</a></p>
</div>

<script src="assets/js/validation.js"></script>
<?php include "includes/footer.php"; ?>
