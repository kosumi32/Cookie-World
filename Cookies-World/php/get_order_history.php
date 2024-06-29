<?php
require 'conn.php';

$response = ['status' => 'error', 'message' => 'Unknown error'];

try {
    // Fetch orders
    $sql = "SELECT o.order_id, o.order_date, o.total_price,
    oi.quantity, c.name, oi.price AS item_price
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN cookies c ON oi.cookieId = c.cookieId
    ORDER BY o.order_date DESC, o.order_id DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $orders = [];
    
    foreach ($result as $row) {
        $orderId = $row['order_id'];
        
        if (!isset($orders[$orderId])) {
            $orders[$orderId] = [
            'order_id' => $orderId,
            'order_date' => $row['order_date'],
            'total_price' => $row['total_price'],
            'items' => []
            ];
        }
        
        $orders[$orderId]['items'][] = [
        'name' => $row['name'],
        'quantity' => $row['quantity'],
        'price' => $row['item_price']
        ];
    }
    
    $response = ['status' => 'success', 'orders' => array_values($orders)];
    
} catch (PDOException $e) {
    $response = ['status' => 'error', 'message' => $e->getMessage()];
} catch (Exception $e) {
    $response = ['status' => 'error', 'message' => $e->getMessage()];
}

// Close connection
$conn = null;

header('Content-Type: application/json');
echo json_encode($response);
?>
