import products from "./products.js";

const cart = () => {
    let iconCart = document.querySelector(".icon-cart");
    let closeBtn = document.querySelector(".cartTab .close");
    let body = document.querySelector("body");
    
    let cart = [];
    
    // open and close the cart
    iconCart.addEventListener("click", () => {
        body.classList.toggle("activeTabCart");
    });
    closeBtn.addEventListener("click", () => {
        body.classList.toggle("activeTabCart");
    });
    
    const populateSavedCardsDropdown = () => {
        fetch('php/getcard.php') // Adjust the path according to your directory structure
        .then(response => response.json())
        .then(data => {
            console.log('Cards fetched:', data); // Debug log to see the fetched data
            if (data.status === 'success') {
                let cards = data.data;
                let dropdown = document.getElementById('savedCardsDropdown');
                
                dropdown.innerHTML = ''; // Clear existing options
                
                cards.forEach((card) => {
                    let option = document.createElement('option');
                    option.value = card.card_id;
                    option.textContent = `${card.card_holder} - ${card.card_number}`;
                    dropdown.appendChild(option);
                });
            } else {
                console.error('Failed to fetch cards:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching cards:', error);
        });    
    };
    
    const setProductInCart = (idProduct, quantity, position) => {
        if (quantity > 0) {
            if (position < 0) {
                cart.push({
                    product_id: idProduct,
                    quantity: quantity
                });
            } else {
                cart[position].quantity = quantity;
            }
        } else {
            cart.splice(position, 1);
        }
        
        localStorage.setItem("cart", JSON.stringify(cart));
        refreshCartHTML();
    };
    
    const refreshCartHTML = () => {
        let listHTML = document.querySelector(".listCart");
        let totalHTML = document.querySelector(".icon-cart span");
        let totalQuantity = 0;
        
        listHTML.innerHTML = null;
        cart.forEach(item => {
            totalQuantity = totalQuantity + item.quantity;
            
            let position = products.findIndex((value) => value.id == item.product_id);
            let info = products[position];
            let newITem = document.createElement("div");
            newITem.classList.add("item");
            newITem.innerHTML =
            `
            <div class="image">
                <img src="${info.image}" />
            </div>
            <div class="name">
                ${info.name}
            </div>
            <div class="totalPrice">$${info.price * item.quantity}</div>
            <div class="quantity">
                <span class="minus" data-id="${info.id}">-</span>
                <span>${item.quantity}</span>
                <span class="plus" data-id="${info.id}">+</span>
            </div>
            `;
            
            listHTML.appendChild(newITem);
        });
        totalHTML.innerText = totalQuantity;
        console.log(cart);
    };
    
    document.getElementById('clearCart').addEventListener('click', () => {
        const userConfirmed = confirm('Are you sure you want to clear your cart?');
        
        if (userConfirmed) {
            clearCart();
            alert('Your cart has been cleared.');
        }
    });
    
    const clearCart = () => {
        cart = [];
        localStorage.removeItem('cart');
        refreshCartHTML();
    };
    
    document.getElementById('checkOut').addEventListener('click', () => {
        fetch('http://localhost/Cookies-World/php/checkout.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ cart: cart })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Checkout Success:', data);
            if (data.status === 'success') {
                clearCart();
            } else {
                alert('Checkout failed: ' + data.message);
            }
        })
        .catch((error) => {
            console.error('Checkout Error:', error);
        });
    });
    
    document.addEventListener('click', (event) => {
        let buttonClick = event.target;
        let idProduct = buttonClick.dataset.id;
        let position = cart.findIndex((value) => value.product_id == idProduct);
        let quantity = position < 0 ? 0 : cart[position].quantity;
        
        if (buttonClick.classList.contains("addCart") || buttonClick.classList.contains("plus")) {
            quantity++;
            setProductInCart(idProduct, quantity, position);
        } else if (buttonClick.classList.contains("minus")) {
            quantity--;
            setProductInCart(idProduct, quantity, position);
        }
    });
    
    const initApp = () => {
        if (localStorage.getItem("cart")) {
            cart = JSON.parse(localStorage.getItem("cart"));
        }
        refreshCartHTML();
        populateSavedCardsDropdown();
    };
    initApp();
};

export default cart;
