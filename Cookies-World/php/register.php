<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Cookies-World";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Insert into SQL
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Your account has been created successfully!');
                window.location.href = '../landingPage.html';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $sql . "<br>" . $conn->error . "');
                window.history.back();
              </script>";
    }

    $conn->close();
}
?>
