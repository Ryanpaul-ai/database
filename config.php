<?php
$conn = mysqli_connect("localhost", "root", "", "login", 3308);

if (!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");
?>