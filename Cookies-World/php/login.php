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
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Check if the password matches
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            echo "<script>
                    alert('Login successfully!');
                    window.location.href = '../landingPage.html';
                  </script>";
        } 
        // Since landingPage.html is in root directory
        else {
            echo "<script>
                    alert('Wrong Password!');
                    window.history.back();
                  </script>";
        }
    } else {
        echo "<script>
                alert('No user found with this email!');
                window.history.back();
              </script>";
    }

    $conn->close();
}
?>
