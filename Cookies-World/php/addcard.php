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
        $cardNumber = $_POST['cardNumberInput'];
        $cardHolder = $_POST['cardHolderInput'];
        $expMonth = $_POST['monthInput'];
        $expYear = $_POST['yearInput'];
        $cvv = $_POST['cvvInput'];
        
        // Validation (simple example, you should add more comprehensive validation)
        if (empty($cardNumber) || empty($cardHolder) || empty($expMonth) || empty($expYear) || empty($cvv)) {
            throw new Exception("All fields are required");
        }
        
        // Prepare the SQL statement
        $sql = "INSERT INTO cards (user_email, card_number, card_holder, exp_month, exp_year, cvv) VALUES (:user_email, :card_number, :card_holder, :exp_month, :exp_year, :cvv)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_email', $userEmail);
        $stmt->bindParam(':card_number', $cardNumber);
        $stmt->bindParam(':card_holder', $cardHolder);
        $stmt->bindParam(':exp_month', $expMonth);
        $stmt->bindParam(':exp_year', $expYear);
        $stmt->bindParam(':cvv', $cvv);
        
        // Execute the prepared statement
        if ($stmt->execute()) {
            $_SESSION['message'] = array("text" => "User successfully created.", "alert" => "info");
            
            // Redirect to index.html
            header('Location: ../profile.php');
        } else {
            throw new Exception("Failed to add card");
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
