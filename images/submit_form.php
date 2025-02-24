<?php
// Database connection settings
$servername = "localhost";  // Your MySQL server address
$username = "root";         // Your MySQL username
$password = "";             // Your MySQL password
$dbname = "sports_zone";    // The database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Check if the form fields are empty
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Prepare an SQL statement to insert the data into the database
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        // Execute the statement
        if ($stmt->execute()) {
            // If the data is successfully inserted, redirect or show success message
            echo "<p>Thank you, " . $name . ". Your message has been sent successfully!</p>";
        } else {
            echo "<p>There was an error while submitting your message. Please try again.</p>";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "<p>All fields are required!</p>";
    }
}

// Close the database connection
$conn->close();
?>
