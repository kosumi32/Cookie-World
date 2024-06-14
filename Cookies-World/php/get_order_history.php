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

// Set email directly (I assume using eugne0123@gmail.com)
$email = "eugene0123@gmail.com";

$response = ['status' => 'error', 'message' => 'Unknown error'];

try {
    // Fetch orders for the user
    $sql = "SELECT o.order_id, o.order_date, o.total_price, o.status,
                   oi.quantity, c.name, c.price
            FROM orders o
            JOIN order_items oi ON o.order_id = oi.order_id
            JOIN cookies c ON oi.cookieId = c.cookieId
            WHERE o.email = ?
            ORDER BY o.order_id DESC"; // Assuming you want to fetch orders in descending order

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];

    while ($row = $result->fetch_assoc()) {
        $orderId = $row['order_id'];

        // Check if order already exists in $orders array
        if (!isset($orders[$orderId])) {
            $orders[$orderId] = [
                'order_id' => $orderId,
                'order_date' => $row['order_date'],
                'total_price' => $row['total_price'],
                'status' => $row['status'],
                'items' => []
            ];
        }

        // Add item to order's items array
        $orders[$orderId]['items'][] = [
            'name' => $row['name'],
            'quantity' => $row['quantity'],
            'price' => $row['price']
        ];
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Format response
    $response = ['status' => 'success', 'orders' => array_values($orders)]; // array_values to reindex array

} catch (Exception $e) {
    $response = ['status' => 'error', 'message' => $e->getMessage()];
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
