<?php
// db.php: Database connection setup

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "enrollment_1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
