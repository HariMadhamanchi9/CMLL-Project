<?php

// Include your database connection code here (use the provided credentials)
$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "signup";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the form
$rNumber = $_POST['R-Id'];
$purpose = $_POST['purpose'];
// Get the captured image data from the hidden input field
$capturedImageData = $_POST['capturedImageData'];


// Save the captured image to a file with a unique filename (e.g., r_number_datetime.jpg)
if ($capturedImageData) {
    $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $capturedImageData));
    $imageFileName = $rNumber . '_' . date("YmdHis") . '.jpg';
    $imageFilePath = 'C:/xampp/htdocs/cmll-project/LABPROJECT with CAMERA/camera/' . $imageFileName;

    // Save the image to the file
    if (file_put_contents($imageFilePath, $imageData)) {
        // Image saved successfully
    } else {
        // Error saving the image
    }
}

// Check if r_number exists in the users table
$sqlCheckUser = "SELECT * FROM users WHERE r_number = '$rNumber'";
$result = $conn->query($sqlCheckUser);

if ($result->num_rows > 0) {
    // r_number exists in the users table, fetch first name and last name
    $row = $result->fetch_assoc();
    $firstName = $row['first_name'];
    $lastName = $row['last_name'];

    // Insert check-in details
    $checkinDate = date("Y-m-d");
    $checkinTime = date("H:i:s", strtotime("-7 hours"));
    $checkoutTime = "00:00:00";

    $sqlInsertCheckin = "INSERT INTO checkins (r_number, purpose, first_name, last_name, checkin_date, checkin_time, checkout_time, checkin_preview) 
                        VALUES ('$rNumber', '$purpose', '$firstName', '$lastName', '$checkinDate', '$checkinTime', '$checkoutTime', '$imageFilePath')";

    if ($conn->query($sqlInsertCheckin) === TRUE) {
        header("Location: sucess.php?rId=$rNumber");
        exit();
    } else {
        echo "Error inserting check-in details: " . $conn->error;
    }
} else {
    // r_number does not exist in the users table, insert user details first
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];

    $sqlInsertUser = "INSERT INTO users (r_number, first_name, last_name, signup_preview) VALUES ('$rNumber', '$firstName', '$lastName','$imageFilePath')";

    if ($conn->query($sqlInsertUser) === TRUE) {
        // Insert check-in details
        $checkinDate = date("Y-m-d");
        $checkinTime = date("H:i:s", strtotime("-7 hours"));
        $checkoutTime = "00:00:00";

        $sqlInsertCheckin = "INSERT INTO checkins (r_number, purpose, first_name, last_name, checkin_date, checkin_time, checkout_time, checkin_preview) 
                            VALUES ('$rNumber', '$purpose', '$firstName', '$lastName', '$checkinDate', '$checkinTime', '$checkoutTime', '$imageFilePath')";

        if ($conn->query($sqlInsertCheckin) === TRUE) {
            header("Location: sucess.php?rId=$rNumber");
            exit();
        } else {
            echo "Error inserting check-in details: " . $conn->error;
        }
    } else {
        echo "Error inserting user details: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
