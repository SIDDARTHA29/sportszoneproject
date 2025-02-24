<?php
// Database connection
$servername = "localhost";  // Change this to your database server
$username = "root";         // Change this to your database username
$password = "";             // Change this to your database password
$dbname = "sports_zone_contact";  // New database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Prepare SQL statement
    $sql = "INSERT INTO contact_form (name, email, message) VALUES (?, ?, ?)";

    // Prepare and bind
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $name, $email, $message);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<p style='color: #4CAF50;'>Thank you, " . htmlspecialchars($name) . ". Your message has been sent successfully!</p>";
        } else {
            echo "<p style='color: #FF5733;'>Error: " . $stmt->error . "</p>";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "<p style='color: #FF5733;'>Error preparing statement: " . $conn->error . "</p>";
    }

    // Close connection
    $conn->close();
} else {
    echo "<p style='color: #FF5733;'>Invalid request method.</p>";
}
?>
