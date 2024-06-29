<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/displayCards.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body onload="initClock()">
    <div class="container">
        <header>
            <div class="headerContainer">
                <h3 class="logo">Cookie World</h3>
                <nav class="navigation">
                    <a href="landingPage.html">Home</a>
                    <a href="howToUse.html">How to use</a>
                    <a href="about.html">About</a>
                    <a href="profile.php">Profile</a>
                </nav>
                <div class="icon-cart">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                    d="M14 7h-4v3a1 1 0 0 1-2 0V7H6a1 1 0 0 0-.997.923l-.917 11.924A2 2 0 0 0 6.08 22h11.84a2 2 0 0 0 1.994-2.153l-.917-11.924A1 1 0 0 0 18 7h-2v3a1 1 0 1 1-2 0V7Zm-2-3a2 2 0 0 0-2 2v1H8V6a4 4 0 0 1 8 0v1h-2V6a2 2 0 0 0-2-2Z"
                    clip-rule="evenodd" />
                </svg>
                <span>0</span>
            </div>
            <a class="btn-login" href="index.html">Login</a>
        </div>
    </header>
    
    <div class="main-content">
        <div class="welcome-section">
            <?php
            session_start();
            if (isset($_SESSION['user_id'])) {
                require_once 'php/conn.php';
                $user_id = $_SESSION['user_id'];
                
                // Fetch user details
                $sql = "SELECT name, phone, email FROM users WHERE id = :user_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($user) {
                    $name = htmlspecialchars($user['name']);
                    $phone = htmlspecialchars($user['phone']);
                    $email = htmlspecialchars($user['email']);
                } else {
                    $name = "Guest";
                    $phone = "-";
                    $email = "-";
                }
                
                // Fetch user cards
                $sql = "SELECT card_number, card_holder, exp_month, exp_year FROM cards WHERE user_email = :user_email";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':user_email', $email);
                $stmt->execute();
                $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            } else {
                $name = "Guest";
                $phone = "-";
                $email = "-";
                $cards = [];
            }
            ?>
            <h1><?php echo $name; ?></h1>
            <p>Phone no.: <?php echo $phone; ?></p>
            <p>Email: <?php echo $email; ?></p>
            <div class="editprofile">
                <a href="edit_profile.html">Edit Profile</a>
            </div>
            <div class="history">
                <a href="order_history.php">Purchase History</a>
            </div>
        </div>
        <div class="account-info">
            <div class="title-section">
                <h2>Cards Available</h2>
                <div class="button-container">
                    <a href="addCardForm.html">
                        <button class="btn" id="add-card-btn">Add New Card</button>
                    </a>
                </div>
            </div>
            <div id="savedCards" class="cards-container">
                <?php if (count($cards) > 0): ?>
                <?php foreach ($cards as $card): ?>
                <div class="saved-card">
                    <div>
                        <p><strong><?php echo htmlspecialchars($card['card_holder']); ?></strong></p>
                    </div>
                    <div>
                        <p><?php echo htmlspecialchars($card['card_number']); ?></p>
                    </div>
                    <div>
                        <p><?php echo htmlspecialchars($card['exp_month'] . '/' . $card['exp_year']); ?></p>
                    </div>
                    <!-- The modal -->
                    <div class="modal" id="myModal" style="display: none;">
                        <div class="modal-content">
                            <p>Are you sure?</p>
                            <div class="btnFlex">
                                <button id="btnYes">Yes</button>
                                <button id="btnNo">No</button>
                            </div>
                        </div>
                    </div>
                    <!-- Remove Card Button and Form -->
                    <div class='remove-card-btn'>
                        <form id="removeCardForm" action="php/removecard.php" method="POST">
                            <input type="hidden" name="cardNumber" value="<?php echo htmlspecialchars($card['card_number']); ?>">
                            <button type="button" id="removeCardBtn">Remove Card</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p>No cards saved yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="trailer"></div>
    <div class="trailer"></div>
    <div class="trailer"></div>
    <div class="trailer"></div>
    <div class="trailer"></div>
    <div class="trailer"></div>
    <div class="trailer"></div>
    <div class="trailer"></div>
    <div class="trailer"></div>
    <div class="trailer"></div>
    <div class="trailer"></div>
</div>

<div class="cartTab">
    <h1>Shopping Cart</h1>
    <div class="listCart">show item here</div>
    <div class="payment-method">
        <label for="savedCardsDropdown">Payment Details</label>
        <select id="savedCardsDropdown">
        </select>
    </div>
    <label for="speReq" class="speReq">Add a specific request</label>
    <input list="Request" id="speReq" name="speReq" class="speReq" />
    <datalist id="Request">
        <option value="Less Sugar"></option>
        <option value="No peanuts"></option>
    </datalist>
    <div class="btn">
        <button id="clearCart">Clear Cart</button>
        <button class="close">Close</button>
        <button class="checkOut" id="checkOut" onclick="location.href = 'order_history.php';">Check
            Out</button>
        </div>
    </div>
    
    <footer>
        <div class="datetime">
            <div class="date">
                <span id="dayname">Day</span>,
                <span id="month">Month</span>
                <span id="daynum">00</span>,
                <span id="year">Year</span>
            </div>
            <div class="time">
                <span id="hour">00</span>:
                <span id="minutes">00</span>:
                <span id="seconds">00</span>
                <span id="period">AM</span>
            </div>
        </div>
    </footer>
    
    <script src="js/clock.js"></script>
    <script src="js/cart.js" type="module"></script>
    <script src="js/profile.js"></script>
    <script src="js/popup.js"></script>
</body>

</html>
