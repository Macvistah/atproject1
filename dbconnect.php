<?php

// Database credentials
$servername = "localhost"; // Replace with your database host
$username = "username"; // Replace with your database username
$password = "password"; // Replace with your database password
$dbname = "database"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

// Close connection
$conn->close();

?>
