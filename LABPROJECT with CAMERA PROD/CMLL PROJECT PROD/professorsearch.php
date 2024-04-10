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

// Get the search query from the GET parameter
if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];

    // Sanitize the input to prevent SQL injection (you should use prepared statements for security)
    $searchQuery = mysqli_real_escape_string($conn, $searchQuery);

    // Query to search for professors whose names contain the search query
    $search_sql = "SELECT professor_name FROM professors WHERE professor_name LIKE '%$searchQuery%'";
    $search_result = $conn->query($search_sql);

    if ($search_result->num_rows > 0) {
        // Display the matching professor names
        while ($row = $search_result->fetch_assoc()) {
            echo "<p>" . $row['professor_name'] . "</p>";
        }
    } else {
        // No matching professors found
        echo "<p>No matching professors found.</p>";
    }
}

// Close the database connection
$conn->close();
?>
