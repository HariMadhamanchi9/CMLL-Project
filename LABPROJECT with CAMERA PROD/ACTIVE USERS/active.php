<?php
// Database credentials
$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "signup";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set timezone to Central Time
date_default_timezone_set('America/Chicago');

// Get current date and time
$currentDate = date("Y-m-d");
$currentDateTime = date("Y-m-d H:i:s");

echo "Current Date: $currentDate<br>";
echo "Current Date and Time: $currentDateTime<br>";

// Prepare SQL query
$sql = "SELECT COUNT(*) as num_users FROM checkins WHERE checkin_date = '$currentDate'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of the count of active users
    $row = $result->fetch_assoc();
    echo "Number of Active Users Today: " . $row["num_users"];
} else {
    echo "0 active users today";
}

// Close connection
$conn->close();
?>
