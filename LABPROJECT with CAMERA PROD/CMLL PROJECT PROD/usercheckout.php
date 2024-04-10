<?php
$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "signup";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get today's date
$todayDate = date("Y-m-d");

// Query to select users where checkout_time is "00:00:00" and checkin_date is not today
$select_sql = "SELECT r_number FROM checkins WHERE checkout_time = '00:00:00' AND checkin_date != '$todayDate'";  

$result = $conn->query($select_sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rNumber = $row['r_number'];
        $checkinTime = $row['checkin_time'];

        // Calculate new checkout time by adding 3 hours to checkin time
        $newCheckoutTime = date('H:i:s', strtotime($checkinTime) + (3 * 60 * 60));

        // Update checkout time in the database
        $update_sql = "UPDATE checkins SET checkout_time = '$newCheckoutTime' WHERE r_number = '$rNumber'";
        if ($conn->query($update_sql) === TRUE) {
            #echo "Checkout time updated for R-number: $rNumber. New checkout time: $newCheckoutTime<br>";
        } else {
           # echo "Error updating checkout time for R-number: $rNumber - " . $conn->error . "<br>";
        }
    }
} else {
    #echo "No users found with checkout_time = '00:00:00' (excluding today)";
}

$conn->close();
?>



<?php
$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "signup";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

