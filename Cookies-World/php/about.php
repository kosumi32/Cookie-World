<?php
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = '';     // Replace with your MySQL password
$dbname = "cookies-world";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    // Retrieve form data
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $details = $_POST['detail'];

    // Insert data into the database
    $sql = "INSERT INTO contact_inquiry (email, subject, details) VALUES ('$email', '$subject', '$details')";
    if ($conn->query($sql) === TRUE) {
        echo "New message posted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetching and displaying the inquiries
$sql = "SELECT email, subject, details, created_at FROM contact_inquiry ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<div class='message'>";
        echo "<strong>Email: " . htmlspecialchars($row["email"]) . "</strong><br>";
        echo "<strong>Subject: " . htmlspecialchars($row["subject"]) . "</strong><br>";
        echo htmlspecialchars($row["details"]);
        echo "<br><small>Posted on: " . $row["created_at"] . "</small>";
        echo "</div><hr>";
    }
} else {
    echo "No messages yet!";
}

// Close the connection
$conn->close();
?>
