<?php 
include 'config.php';

$message = "";
$messageType = "";

if (isset($_POST['register'])){
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if($username == "" || $password == ""){
        $message = "Please Fill in all Fields.";
        $messageType = "Error";
    } 
    elseif (strlen($password) < 8) {
        $message = "Password must be at least 8 characters.";
        $mesageType = "Error";
    } 

    else {
        $check = mysqli_prepare($conn,
        "SELECT Id FROM user WHERE username = ?" );

    mysqli_stmt_bind_param($check, "s", $username);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) > 0){
        $message = "Username Already Exist.";
        $mesageType = "Error";
    }

    else {
        $hashedPassword = password_hash(
            $password, PASSWORD_DEFAULT );

        $stmt = mysqli_prepare($conn,
        "INSERT INTO user (username, password) VALUES (?,?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ss",
            $username,
            $hashedPassword
        );

        if (mysqli_stmt_execute($stmt)){
            $message = "Registration Successfull! You can now log in.";
            $messageType = "Success";
        } 
        
        else {
            $message = "Registration Failed. Please Try Again.";
            $messageType = "Error"; 
        }
        mysqli_stmt_close($check);
    }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h2>Create an Account</h2>
        <p class="subtitle">Register for a new Account</p>

        <?php if ($message != ""):?>
            <p class="message <?php echo $messageType; ?>">
            <?php echo htmlspecialchars($message); ?>
            </p>
        <?php endif;?>

<form method="POST" action="">
    <label>Username</label>
    <input type = "text" name = "username" maxlength = "50" required><br>

    <label>Password</label>
    <input type = "password" name = "password" minlength = "8" required><br>

    <button type = "subnmit" name = "register">Register</button><br>
        </form>
        <p clas="footer">Already Have an Account?<a href="index.php">Log In Here</a></p>
        </div>
    </body>
</html>