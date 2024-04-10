<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify User Data</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 50px;
            text-align: center;
            background-color: #f4f4f4;
            background-image: url('image3.png');
        }

        h2 {
            color: #333;
        }

        form {
            margin-top: 20px;
            display: inline-block;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        select,
        input[type="submit"],
        input[type="button"] {
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            width: 100%;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .user-details {
            margin-top: 20px;
            width: 300px;
            display: inline-block;
            text-align: left;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .user-details h2 {
            color: #333;
        }

        .user-details p {
            margin: 5px 0;
        }

        .updated-details {
            background-color: #e6f7ff;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }

        input[type="button"] {
            padding: 10px;
            margin-top: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        input[type="button"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <?php
    // Database connection parameters
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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // If the form is submitted, retrieve and display user details
        $r_number = $_POST["r_number"];

        $sql = "SELECT * FROM users WHERE r_number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $r_number);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Display user details using JavaScript
            echo "<div class='user-details' id='userDetails'>";
            echo "<h2>User Details</h2>";
            echo "<p><strong>R_Number:</strong> " . $user['r_number'] . "</p>";
            echo "<p><strong>First Name:</strong> " . $user['first_name'] . "</p>";
            echo "<p><strong>Last Name:</strong> " . $user['last_name'] . "</p>";

            // Update user details in the database
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_option']) && isset($_POST['new_value'])) {
                $change_option = $_POST['change_option'];
                $new_value = $_POST['new_value'];

                // Update the user details
                $update_sql = "UPDATE users SET $change_option = ? WHERE r_number = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("ss", $new_value, $r_number);
                $update_stmt->execute();
                $update_stmt->close();

                // Fetch and display the updated user details
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
                
                echo "<div class='updated-details'>";
                echo "<h2>Updated User Details</h2>";
                echo "<p><strong>R_Number:</strong> " . $user['r_number'] . "</p>";
                echo "<p><strong>First Name:</strong> " . $user['first_name'] . "</p>";
                echo "<p><strong>Last Name:</strong> " . $user['last_name'] . "</p>";
                echo "</div>";
            }

            // Dropdown list for modification
            echo "<form action='' method='post'>";
            echo "<input type='hidden' name='r_number' value='" . $user['r_number'] . "'>";
            echo "<label for='change_option'>Change:</label>";
            echo "<select name='change_option' id='change_option'>
                    <option value='first_name'>First Name</option>
                    <option value='last_name'>Last Name</option>
                </select>";
            echo "<br>";
            echo "New Value: <input type='text' name='new_value' required>";
            echo "<br>";
            echo "<input type='submit' value='Submit'>";
            echo "</form>";

            // Delete user form
            echo "<form action='' method='post'>";
            echo "<input type='hidden' name='r_number' value='" . $user['r_number'] . "'>";
            echo "<input type='submit' name='delete_user' value='Delete'>";
            echo "</form>";

            // Back button
            echo "<input type='button' value='Back' onclick='history.back()'>";
            echo "</div>";
        } else {
            echo "<p>User not found.</p>";
        }

        // Delete user logic
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
            $delete_r_number = $_POST['r_number'];

            // Delete the user from the database
            $delete_sql = "DELETE FROM users WHERE r_number = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("s", $delete_r_number);
            $delete_stmt->execute();
            $delete_stmt->close();

            echo "<p>User deleted successfully.</p>";
        }

        $stmt->close();
    } else {
        ?>
        <h2>Enter R_Number to Retrieve User Data</h2>
        <form action="" method="post">
            R_Number: <input type="text" name="r_number" required>
            <br>
            <input type="submit" value="Submit">
        </form>
        <?php
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
