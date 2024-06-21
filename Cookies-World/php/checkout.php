<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL password
$dbname = "cookies-world";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the posted data
$data = json_decode(file_get_contents('php://input'), true);
$cart = $data['cart'];
$email = 'eugene0123@gmail.com'; // Assuming you're passing email of the user

$response = ['status' => 'error', 'message' => 'Unknown error'];

// Begin transaction for atomicity
$conn->begin_transaction();

try {
    // Insert into orders table
    $totalPrice = 0;
    $stmt = $conn->prepare("INSERT INTO orders (email, total_price) VALUES (?, ?)");
    $stmt->bind_param("sd", $email, $totalPrice);
    $stmt->execute();

    $orderId = $stmt->insert_id; // Get the inserted order_id

    // Insert into order_items table
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, cookieId, quantity, price) VALUES (?, ?, ?, ?)");

    foreach ($cart as $item) {
        $cookieId = $item['product_id'];
        $quantity = $item['quantity'];

        // Fetch price of the cookie from cookies table
        $fetchPriceStmt = $conn->prepare("SELECT price FROM cookies WHERE cookieId = ?");
        $fetchPriceStmt->bind_param("i", $cookieId);
        $fetchPriceStmt->execute();
        $fetchPriceStmt->bind_result($price);
        $fetchPriceStmt->fetch();
        $fetchPriceStmt->close();

        $pricePerItem = $price;
        $totalPrice += $quantity * $pricePerItem;

        // Insert into order_items
        $stmt->bind_param("iiid", $orderId, $cookieId, $quantity, $pricePerItem);
        $stmt->execute();
    }

    // Update total_price in orders table
    $updateStmt = $conn->prepare("UPDATE orders SET total_price = ? WHERE order_id = ?");
    $updateStmt->bind_param("di", $totalPrice, $orderId);
    $updateStmt->execute();

    // Commit transaction
    $conn->commit();

    $response = ['status' => 'success', 'order_id' => $orderId];
} catch (Exception $e) {
    // Rollback transaction on failure
    $conn->rollback();
    $response = ['status' => 'error', 'message' => $e->getMessage()];
}

$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
