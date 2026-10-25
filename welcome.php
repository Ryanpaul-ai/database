<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'] ?? 'User';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container welcome-container">
        <div class="success-icon">&#10003;</div>

        <h2>Login Successful!</h2>

        <p class="subtitle">
            Welcome, <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>!
        </p>

        <p class="welcome-text">
            You have successfully logged in to your account.
        </p>

        <a class="button-link" href="logout.php">Logout</a>
    </div>

    </body>
</html>