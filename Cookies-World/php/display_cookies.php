<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style-order-history.css">
    <link rel="stylesheet" href="../css/display_cookies.css">
</head>
<body>
    <header>
        <div class="headerContainer">
            <h3 class="logo">Cookie World</h3>
            <nav class="navigation">
                <a href="../landingPage.html">Home</a>
                <a href="../howToUse.html">How to use</a>
                <a href="../about.html">About</a>
                <a href="../profile.php">Profile</a>
            </nav>
            <!-- Cart Icon -->
            <div class="icon-cart">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                d="M14 7h-4v3a1 1 0 0 1-2 0V7H6a1 1 0 0 0-.997.923l-.917 11.924A2 2 0 0 0 6.08 22h11.84a2 2 0 0 0 1.994-2.153l-.917-11.924A1 1 0 0 0 18 7h-2v3a1 1 0 1 1-2 0V7Zm-2-3a2 2 0 0 0-2 2v1H8V6a4 4 0 0 1 8 0v1h-2V6a2 2 0 0 0-2-2Z"
                clip-rule="evenodd" />
            </svg>
            <!-- display no of product -->
            <span>0</span>
        </div>
        <a class="btn-login" href="index.html">Login</a>
    </div>
</header>
<h2 class="title">List of Cookies</h2>

<div class="container">
    <?php
    require_once 'conn.php';
    
    try {
        // SQL query to select data from the "cookies" table
        $sql = "SELECT cookieId, name, price, description FROM cookies";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        // Fetch all results
        $cookies = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Check if there are results and display them
        if (count($cookies) > 0) {
            echo "<table border='1'>
                <tr>
                    <th>Cookie ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                </tr>";
                // Output data of each row
                foreach ($cookies as $cookie) {
                    echo "<tr>
                        <td>" . htmlspecialchars($cookie["cookieId"]) . "</td>
                        <td>" . htmlspecialchars($cookie["name"]) . "</td>
                        <td>" . htmlspecialchars($cookie["price"]) . "</td>
                        <td>" . htmlspecialchars($cookie["description"]) . "</td>
                    </tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        
        // Close connection
        $conn = null;
        ?>  
    </div>
    <button id="back" onclick="history.back()">Go Back</button>
</body>
</html>
