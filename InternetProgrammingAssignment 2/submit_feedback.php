<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "campaign_feedback";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $feedback = isset($_POST['feedback']) ? $_POST['feedback'] : '';
    $rating = isset($_POST['rating']) ? $_POST['rating'] : '';

    // Validate form fields to make sure they are not empty
    if (!empty($name) && !empty($email) && !empty($feedback) && !empty($rating)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO feedback (name, email, feedback, rating) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $email, $feedback, $rating);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "Feedback submitted successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }  
    } else {
        echo "All fields are required.";
    }
} else {
    echo "Invalid request method.";
}

// Close connections
$conn->close();
?>
