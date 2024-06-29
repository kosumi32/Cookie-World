<?php
session_start();
require_once 'conn.php';

// Enable detailed error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$response = ['status' => 'error', 'message' => 'Unknown error'];

if (isset($_SESSION['user_email'])) {
    try {
        $userEmail = $_SESSION['user_email'];
        
        // Prepare the SQL statement
        $sql = "SELECT id, card_holder, card_number FROM cards WHERE user_email = :user_email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_email', $userEmail);
        $stmt->execute();
        
        $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($cards) {
            $response['status'] = 'success';
            $response['data'] = $cards;
        } else {
            $response['message'] = 'No cards found';
        }
    } catch (PDOException $e) {
        $response['message'] = "Database Error: " . $e->getMessage();
    } catch (Exception $e) {
        $response['message'] = "Error: " . $e->getMessage();
    }
} else {
    $response['message'] = "User not logged in";
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
