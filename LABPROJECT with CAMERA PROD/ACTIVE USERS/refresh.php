<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .refresh-button-container {
            position: absolute;
            top: 0;
            left: 1;
            right: 0;
            display: flex;
            justify-content: center;
            padding: 30px 10px;
        }

        .refresh-button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 10px;
            border: none;
            cursor: pointer;
            border-radius: 0px;
        }

        .refresh-button:hover {
            background-color: #45a049;
        }

        .user-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .user-item {
            display: flex;
            background-color: #ffffff;
            border: 1px solid #ddd;
        }

        .user-info {
            flex: 1;
            padding: 10px;
            text-align: center;
            border-right: 2px solid #ddd;
            min-width: 5px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .user-info strong {
            font-weight: bold;
        }

        .user-info:last-child {
            border-right: none;
        }

        .image-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-container img {
            max-width: 50px;
            max-height: 50px;
            margin: 5px;
            transition: transform 0.2s;
        }

        .image-container img:hover {
            transform: scale(1.9);
        }

        .images-list {
            display: flex;
            flex-wrap: wrap;
        }

        .images-list img {
            max-width: 60px;
            max-height: 80px;
            margin: 5px;
            transition: transform 0.3s;
        }

        .images-list img:hover {
            transform: scale(4.9);
        }




        /* Adjust the widths of the columns */
.user-info:nth-child(1) {
    flex-basis: 70px; /* Width of the R Number column */
}

.user-info:nth-child(2) {
    flex-basis: 80px; /* Width of the Purpose column */
}

.user-info:nth-child(3) {
    flex-basis: 100px; /* Width of the First Name column */
}

.user-info:nth-child(4) {
    flex-basis: 100px; /* Width of the Last Name column */
}

.user-info:nth-child(5) {
    flex-basis: 120px; /* Width of the Checkin Time column */
}

.user-info:nth-child(6) {
    flex-basis: 120px; /* Width of the Checkout Time column */
}

.user-info:last-child {
    flex-basis: 150px; /* Width of the Images column */
}

/* Adjust image size */
.images-list img {
    max-width: 40px; /* Adjust the maximum width of images */
    max-height: 40px; /* Adjust the maximum height of images */
}




    </style>
</head>
<body>
<div class="refresh-button-container">
        <button class="refresh-button" onclick="location.reload()">Manual Refresh</button>
    </div>

    <div style="padding: 20px;">
        <h3>Today's Users</h3>
        <ul class="user-list">
            <li class='user-item'>
                <div class='user-info'>
                    <strong>R Number</strong>
                </div>
                <div class='user-info'>
                    <strong>Purpose</strong>
                </div>
                <div class='user-info'>
                    <strong>First Name</strong>
                </div>
                <div class='user-info'>
                    <strong>Last Name</strong>
                </div>
                <div class='user-info'>
                    <strong>Checkin Time</strong>
                </div>
                <div class='user-info'>
                    <strong>Checkout Time</strong>
                </div>
                <div class='user-info'>
                    <strong>Images</strong>
                </div>
            </li>
            <!-- PHP code for user data goes here -->
        </ul>
    </div>


    <script>
        function autoRefresh() {
            setTimeout(function () {
                location.reload();
            },180000); // 3 minutes (3 * 60 * 1000 milliseconds)
        }
        autoRefresh(); // Call the function when the page loads
    </script>


    <?php
    // Database connection information
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
    // Set timezone to Central Time
    date_default_timezone_set('America/Chicago');

    // Get the current date
    $currentDate = date("Y-m-d");


    // SQL query to fetch active users for the current date with check-in time before 7 pm
    
//$sql = "SELECT r_number, first_name, last_name, purpose, checkin_time, checkout_time FROM checkins WHERE checkin_date = '$currentDate' ORDER BY checkin_time DESC";

// SQL query to fetch active users for the current date with check-in time after 5 PM
$sql = "SELECT r_number, first_name, last_name, purpose, checkin_time, checkout_time FROM checkins WHERE checkin_date = '$currentDate' AND TIME(checkin_time) <= '20:00:00'  ORDER BY checkin_time DESC";

$result = $conn->query($sql);


    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<ul class='user-list'>";
            echo "<li class='user-item'>";
            echo "<div class='user-info'>" . $row["r_number"] . "</div>";
            echo "<div class='user-info'>" . $row["purpose"] . "</div>";
            echo "<div class='user-info'>" . $row["first_name"] . "</div>";
            echo "<div class='user-info'>" . $row["last_name"] . "</div>";
            echo "<div class='user-info'>" . $row["checkin_time"] . "</div>";
            echo "<div class='user-info'>" . $row["checkout_time"] . "</div>";
            $r_number = $row["r_number"];
            $imagePath = "C:/xampp/htdocs/cmll-project/LABPROJECT with CAMERA/camera/";
            $images = glob($imagePath . $r_number . "_*.{jpg,jpeg,png,gif}", GLOB_BRACE);
    
            // Sort images in descending order based on the file name (assuming the name contains a timestamp)
            rsort($images);
    
            if (count($images) > 0) {
                echo "<div class='user-info'>";
                echo "<div class='images-list'>";
                $count = 0; // Keep track of the number of images displayed
                foreach ($images as $image) {
                    if ($count >= 4) {
                        break; // Display up to 4 images
                    }
                    $imageData = file_get_contents($image);
                    $base64Image = base64_encode($imageData);
                    echo "<img src='data:image/jpeg;base64, $base64Image' alt='$image' />";
                    $count++;
                }
                echo "</div>";
                echo "</div>";
            } else {
                echo "<div class='user-info'>No images found for this user.</div>";
            }
            echo "</li>";
            echo "</ul>";
        }
    } else {
        echo "<p>No active users found for today.</p>";
    }
    
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
