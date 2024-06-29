<?php
include 'conn.php'; // Include database connection file


// Function to post a review to the database
function postReview($conn, $Email, $StoreID, $PublishTime, $Rating, $Content) {
    $ReviewID = $Email . $StoreID . $PublishTime;
    $sql = "INSERT INTO reviewcookie (ReviewID, Email, StoreID, PublishTime, Rating, Content) 
    VALUES (:ReviewID, :Email, :StoreID, :PublishTime, :Rating, :Content)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':ReviewID', $ReviewID);
    $stmt->bindParam(':Email', $Email);
    $stmt->bindParam(':StoreID', $StoreID);
    $stmt->bindParam(':PublishTime', $PublishTime);
    $stmt->bindParam(':Rating', $Rating);
    $stmt->bindParam(':Content', $Content);
    
    if ($stmt->execute()) {
        echo "Review posted successfully!";
    } else {
        echo "Error posting the review.";
    }
}

// Function to fetch all reviews from the database
function getReviews($conn) {
    $sql = "SELECT * FROM reviewcookie ORDER BY PublishTime DESC";
    $stmt = $conn->query($sql);
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $reviews;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $Email = $_POST['Email'];
    $Content = $_POST['Content'];
    $Rating = $_POST['Rating'];
    $StoreID = 1; // Assuming StoreID is fixed or can be determined
    $PublishTime = date("Y-m-d H:i:s"); // Current date and time
    
    // Call the postReview function
    postReview($conn, $Email, $StoreID, $PublishTime, $Rating, $Content);
}

// Fetch all reviews and output them as JSON
$reviews = getReviews($conn);
header('Content-Type: application/json');
echo json_encode($reviews);
?>
