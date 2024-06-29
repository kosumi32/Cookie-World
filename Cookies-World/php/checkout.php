<?php
session_start();
require_once 'conn.php';

// Get the posted data
$data = json_decode(file_get_contents('php://input'), true);
$cart = $data['cart'];

$email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'guest';

$response = ['status' => 'error', 'message' => 'Unknown error'];

try {
    // Begin transaction for atomicity
    $conn->beginTransaction();
    
    // Insert into orders table
    $totalPrice = 0;
    $stmt = $conn->prepare("INSERT INTO orders (email, total_price) VALUES (:email, :total_price)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':total_price', $totalPrice);
    $stmt->execute();
    
    $orderId = $conn->lastInsertId(); // Get the inserted order_id
    
    // Insert into order_items table
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, cookieId, quantity, price) VALUES (:order_id, :cookieId, :quantity, :price)");
    
    foreach ($cart as $item) {
        $cookieId = $item['product_id'];
        $quantity = $item['quantity'];
        
        // Fetch price of the cookie from cookies table
        $fetchPriceStmt = $conn->prepare("SELECT price FROM cookies WHERE cookieId = :cookieId");
        $fetchPriceStmt->bindParam(':cookieId', $cookieId);
        $fetchPriceStmt->execute();
        $price = $fetchPriceStmt->fetchColumn();
        
        $pricePerItem = $price;
        $totalPrice += $quantity * $pricePerItem;
        
        // Insert into order_items
        $stmt->bindParam(':order_id', $orderId);
        $stmt->bindParam(':cookieId', $cookieId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $pricePerItem);
        $stmt->execute();
    }
    
    // Update total_price in orders table
    $updateStmt = $conn->prepare("UPDATE orders SET total_price = :total_price WHERE order_id = :order_id");
    $updateStmt->bindParam(':total_price', $totalPrice);
    $updateStmt->bindParam(':order_id', $orderId);
    $updateStmt->execute();
    
    // Commit transaction
    $conn->commit();
    
    $response = ['status' => 'success', 'order_id' => $orderId];
} catch (Exception $e) {
    // Rollback transaction on failure
    $conn->rollBack();
    $response = ['status' => 'error', 'message' => $e->getMessage()];
}

// Close connection
$conn = null;

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
