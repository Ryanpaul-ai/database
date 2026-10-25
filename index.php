<?php
session_start();
include 'config.php';

$message = "";

if (isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === "" || $password === "") {
        $message = "Please fill in all fields.";
    } else {
        $stmt = mysqli_prepare(
            $conn,
            "SELECT Id, username, password FROM user WHERE username = ?"
        );

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['Id'];
                $_SESSION['username'] = $user['username'];

                header("Location: welcome.php");
                    exit;
            } else {
                $message = "Invalid username or password.";
            }

            mysqli_stmt_close($stmt);
        } else {
            $message = "Unable to process login. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h2>Welcome Back</h2>
        <p class="subtitle">Login to your account</p>

        <?php if ($message !== ""): ?>
            <p class="message">
                <?php echo $message; ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="">
            <label>Username</label>
            <input type="text" name="username" maxlength="50" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit" name="login">Login</button>
        </form>

        <p class="footer">
            Don't have an account?
            <a href="register.php">Register here</a>
        </p>
    </div>

</body>
</html>
\