<?php
$conn = mysqli_connect("localhost", "root", "", "formsdb");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>