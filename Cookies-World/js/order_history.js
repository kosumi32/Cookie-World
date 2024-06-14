document.addEventListener('DOMContentLoaded', () => {
    const email = 'eugene0123@gmail.com'; // Hardcoded email value, can delete it if retrieved from database, line 18 change to ${order.email}

    fetch(`http://localhost/Cookies-World/php/get_order_history.php?email=${encodeURIComponent(email)}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const orderHistory = data.orders;
                const orderHistoryContainer = document.querySelector('.order-history');

                orderHistory.forEach(order => {
                    const orderBlock = document.createElement('div');
                    orderBlock.classList.add('orderBlock');

                    orderBlock.innerHTML = `
                        <h3 class="order-id">#${order.order_id}</h3>
                        <h4 class="order-time">${order.order_date}</h4>
                        <h4 class="order-email">${"eugene0123@gmail.com"}</h4> 
                        <h4 class="order">Order:</h4>
                        <table>
                            ${order.items.map(item => `
                                <tr>
                                    <td class="item-name">${item.name}</td>
                                    <td class="quantity">x ${item.quantity}</td>
                                    <td class="item-price">RM ${item.price}</td>
                                </tr>
                            `).join('')}
                            <tr>
                                <td><h4>Total:</h4></td>
                                <td></td>
                                <td><h4>RM ${order.total_price}</h4></td>
                            </tr>
                        </table>
                        <h4 class="status">Status: ${order.status}</h4>
                    `;

                    orderHistoryContainer.appendChild(orderBlock);
                });
            } else {
                console.error('Failed to fetch order history:', data.message);
            }
        })
        .catch(error => console.error('Error fetching order history:', error));
});
