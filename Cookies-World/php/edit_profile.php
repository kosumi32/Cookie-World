<?php
session_start();
require_once 'conn.php';

// Enable detailed error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if form fields are filled
    if (!empty($_POST['name']) && !empty($_POST['phone']) && !empty($_POST['password'])) {
        try {
            $email = $_SESSION['user_email'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            
            // Prepare the SQL statement
            $sql = "UPDATE users SET name = :name, phone = :phone, password = :password WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':email', $email);
            
            // Execute the prepared statement
            if ($stmt->execute()) {
                // Set session message
                $_SESSION['message'] = array("text" => "Profile successfully updated.", "alert" => "info");
                
                // Redirect to profile page
                header('Location: ../profile.php');
                exit();
            } else {
                throw new Exception("Failed to execute the query.");
            }
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        // Missing form data
        echo "<script>alert('Please fill up the required fields!');</script>";
        echo "<script>window.location = 'edit_profile.html';</script>";
    }
} else {
    // Invalid request method
    echo "Invalid request method.";
}
?>
