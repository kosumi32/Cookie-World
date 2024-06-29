<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="css/style-order-history.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
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
            <button class="btn-login">Login</button>
        </div>
    </header>
    
    <h2 class="title">History</h2>
    
    <div class="order-history" id="order-history">
        <!-- Order history will be loaded here -->
    </div>
    
    <button class="printOrders" onclick="printOrders()">Print Orders</button>
    
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

<script src="js/order_customer_page.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchOrders();
    });
    
    function fetchOrders() {
        fetch('php/get_order_history.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const orders = data.orders;
                const orderHistoryContainer = document.getElementById('order-history');
                orders.forEach(order => {
                    const orderBlock = document.createElement('div');
                    orderBlock.className = 'orderBlock';
                    
                    const orderId = document.createElement('h3');
                    orderId.className = 'order-id';
                    orderId.textContent = '#' + order.order_id;
                    
                    const orderTime = document.createElement('h4');
                    orderTime.className = 'order-time';
                    orderTime.textContent = order.order_date;
                    
                    const orderTitle = document.createElement('h4');
                    orderTitle.className = 'order';
                    orderTitle.textContent = 'Order:';
                    
                    const orderTable = document.createElement('table');
                    
                    order.items.forEach(item => {
                        const row = document.createElement('tr');
                        const itemName = document.createElement('td');
                        itemName.className = 'item-name';
                        itemName.textContent = item.name;
                        
                        const quantity = document.createElement('td');
                        quantity.className = 'quantity';
                        quantity.textContent = 'x ' + item.quantity;
                        
                        const itemPrice = document.createElement('td');
                        itemPrice.className = 'item-price';
                        itemPrice.textContent = 'RM ' + item.price;
                        
                        row.appendChild(itemName);
                        row.appendChild(quantity);
                        row.appendChild(itemPrice);
                        orderTable.appendChild(row);
                    });
                    
                    const totalRow = document.createElement('tr');
                    const totalLabel = document.createElement('td');
                    totalLabel.textContent = 'Total:';
                    totalLabel.style.fontWeight = 'bold';
                    
                    const totalPrice = document.createElement('td');
                    totalPrice.colSpan = 2;
                    totalPrice.style.textAlign = 'right';
                    totalPrice.style.fontWeight = 'bold';
                    totalPrice.textContent = 'RM ' + order.total_price;
                    
                    totalRow.appendChild(totalLabel);
                    totalRow.appendChild(totalPrice);
                    orderTable.appendChild(totalRow);
                    
                    orderBlock.appendChild(orderId);
                    orderBlock.appendChild(orderTime);
                    orderBlock.appendChild(orderTitle);
                    orderBlock.appendChild(orderTable);
                    
                    orderHistoryContainer.appendChild(orderBlock);
                });
            } else {
                console.error('Failed to fetch orders:', data.message);
            }
        })
        .catch(error => console.error('Error fetching orders:', error));
    }
</script>
</body>
</html>
