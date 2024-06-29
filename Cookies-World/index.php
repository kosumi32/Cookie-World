<?php
// include 'about.html'; //this one can change to the html page u wanna put
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = '';     // Replace with your MySQL password
$dbname = "cookieworld";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = null;
$subject = null;
$details = null;

if (isset($_POST['submit'])) {
    // Retrieve form data
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $details = $_POST['details'];

    // Call the postReview function
    postInquiry($email, $subject, $details, $conn);
}

//function to insert data into database
function postInquiry($email, $subject, $details, $conn)
{
    $sql = "INSERT INTO contact_inquiry (email, subject, details) VALUES ('$email', '$subject', '$details')";
    if ($conn->query($sql) === TRUE) {
        echo "New message posted successfully!";
    } else {
        echo "Error";
    };
}


?>


<!-- For testing purpose -->
<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Inquiries</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .message {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px 0;
            background-color: #f9f9f9;
        }

        .message strong {
            font-size: 1.2em;
        }

        .message small {
            color: #555;
        }

        hr {
            border: 0;
            height: 1px;
            background: #ddd;
        }

        form {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <h1>Message Board</h1>
    <form method="post" action="index.php">
        <input type="email" name="email" placeholder="Your Email" required><br>
        <input type="text" name="subject" placeholder="Subject" required><br>
        <textarea name="details" placeholder="Your Message" rows=10 cols=40 required></textarea><br>
        <input type="submit" name="submit" value="Post Message">
    </form>

    <h2>Messages:</h2>
    <?php
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
</body>

</html> -->