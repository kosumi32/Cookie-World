<?php
session_start();
require_once 'conn.php';

// Enable detailed error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Handle form submissions
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $subject = $_POST['subject'];
            $details = $_POST['details'];
            
            // Prepare and execute the SQL statement
            $sql = "INSERT INTO contact_inquiry (user_id, subject, details) VALUES (:user_id, :subject, :details)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':details', $details);
            $stmt->execute();
            
            header("Location: ../about.html");
            
        } else {
            echo "You must be logged in to submit an inquiry.";
        }
    }
} catch(PDOException $e) {
    echo "Database Error: " . $e->getMessage();
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
