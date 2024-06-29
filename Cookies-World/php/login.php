<?php
session_start();
require_once 'conn.php';

// Enable detailed error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if form fields are filled
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        try {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            // Prepare the SQL statement
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            
            // Execute the prepared statement
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['password'])) {
                // Password is correct, set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['logged_in'] = true;
                
                // Redirect to a logged-in page (e.g., profile page)
                header('Location: ../landingPage.html');
                exit();
            } else {
                // Invalid credentials
                $_SESSION['message'] = array("text" => "Invalid email or password.", "alert" => "danger");
                header('Location: ../index.html');
                exit();
            }
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        // Missing form data
        echo "<script>alert('Please fill up the required fields!');</script>";
        echo "<script>window.location = '../index.html';</script>";
    }
} else {
    // Invalid request method
    echo "Invalid request method.";
}
?>
