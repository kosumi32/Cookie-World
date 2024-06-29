<?php
session_start();
require_once 'conn.php';

// Enable detailed error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$response = ['status' => 'error', 'message' => 'Unknown error'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Check if user is logged in
        if (!isset($_SESSION['user_email'])) {
            throw new Exception("User not logged in");
        }
        
        $userEmail = $_SESSION['user_email'];
        
        // Get posted data
        $cardNumber = $_POST['cardNumber'];
        
        // Validate input
        if (empty($cardNumber)) {
            throw new Exception("Card number is required");
        }
        
        // Prepare the SQL statement
        $sql = "DELETE FROM cards WHERE card_number = :card_number AND user_email = :user_email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':card_number', $cardNumber);
        $stmt->bindParam(':user_email', $userEmail);
        
        // Execute the prepared statement
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Card successfully removed';
            header('Location: ../profile.php');
        } else {
            throw new Exception("Failed to remove card");
        }
    } catch (PDOException $e) {
        $response['message'] = "Database Error: " . $e->getMessage();
    } catch (Exception $e) {
        $response['message'] = "Error: " . $e->getMessage();
    }
} else {
    $response['message'] = "Invalid request method.";
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
