<?php 
include 'shoppingCart.html';
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = '';     // Replace with your MySQL password
$dbname = "cookieworld";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
function postReview($Email, $StoreID, $PublishTime, $Rating, $Content,$conn){
    $ReviewID = $Email.$StoreID.$PublishTime;
    $sql = "INSERT INTO reviewcookie (ReviewID, Email, StoreID, PublishTime, Rating, Content) VALUES 
    ('$ReviewID', '$Email', $StoreID, '$PublishTime', $Rating, '$Content')";
    if ($conn->query($sql) === TRUE) {
        echo "New message posted successfully!";
        }
    else{
        echo "Error";
    };
}
if(isset($_POST['submit'])) {
    // Retrieve form data
    $Email = $_POST['Email'];
    $Content = $_POST['Content'];
    $Rating = $_POST['Rating'];
    $StoreID = 1; // You may change this according to your logic
    $PublishTime = date("Y-m-d H:i:s"); // Current date and time

    // Call the postReview function
    postReview($Email, $StoreID, $PublishTime, $Rating, $Content,$conn);
}


function getReview($conn){
    $sql = "SELECT ReviewID, Email, StoreID, PublishTime, Rating, Content FROM reviewcookie ORDER BY PublishTime DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $reviewData = array();
        while ($row = $result->fetch_assoc()) {
            // Create a temporary array for each row
            $tempArray = array(
                $row["ReviewID"],
                $row["Email"],
                $row["StoreID"],
                $row["PublishTime"],
                $row["Rating"],
                $row["Content"]
            );
            // Push the temporary array into $reviewData
            array_push($reviewData, $tempArray);
        }
        return $reviewData;
    } else {
        return "No reviews yet!";
    }
}
?>
<script>
    function createReview(){
        let Review = document.getElementById('latestReviews');
        var arrayData = <?php echo json_encode(getReview($conn)); ?>;
        console.log(arrayData); 
        for(let i = 0; i < arrayData.length; i++){
            let newReview = document.createElement('div');
            newReview.className = 'reviewContent';
            newReview.innerHTML = `
                <div>
                    <p>
                        ${arrayData[i][3]} <br>
                        <strong>${arrayData[i][1]} Says:</strong></br>
                    
                    ${arrayData[i][5]}</br>
                    Giving ${arrayData[i][4]} amount of Stars</p>
                </div>
            `;
            Review.appendChild(newReview);
        }
    }
    createReview();
    
</script>