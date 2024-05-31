import products from "./products.js";

const cart = () => {
    let iconCart = document.querySelector(".icon-cart");
    let closeBtn = document.querySelector(".cartTab .close");
    let body = document.querySelector("body");

    let cart = [];

    // open and close the cart
    iconCart.addEventListener("click", () => {
        body.classList.toggle("activeTabCart");
    })
    closeBtn.addEventListener("click", () => {
        body.classList.toggle("activeTabCart");
    })

    const populateSavedCardsDropdown = () => {
        let cards = JSON.parse(localStorage.getItem('cards')) || [];
        let dropdown = document.getElementById('savedCardsDropdown');

        dropdown.innerHTML = ''; // Clear existing options

        cards.forEach((card, index) => {
            let option = document.createElement('option');
            option.value = index;
            option.textContent = `${card.cardHolder} - ${card.cardNumber}`;
            dropdown.appendChild(option);
        });
    };

    const setProductInCart = (idProduct, quantity, position) => {
        if (quantity > 0) {
            if (position < 0) {
                cart.push({
                    product_id: idProduct,
                    quantity: quantity
                })
            } else {
                cart[position].quantity = quantity;
            }

            // Remove it completely from the cart if "0"
        } else {
            cart.splice(position, 1)
        }

        // Retain data even turn off computer/ browser
        // Save it in local storage
        localStorage.setItem("cart", JSON.stringify(cart));

        // Function the display data on shopping cart
        refreshCartHTML();
    }

    const refreshCartHTML = () => {
        let listHTML = document.querySelector(".listCart");
        let totalHTML = document.querySelector(".icon-cart span");
        let totalQuantity = 0;

        // DONT LET IT DUPLICATE 
        listHTML.innerHTML = null;
        cart.forEach(item => {
            totalQuantity = totalQuantity + item.quantity;

            let position = products.findIndex((value) => value.id == item.product_id);
            let info = products[position];
            let newITem = document.createElement("div");
            newITem.classList.add("item");
            newITem.innerHTML =
                // <div class= "image"> to go to detail page
                `
                    <div class= "image">
                            <img src="${info.image}" />
                        </div>
                        <div class= "name">
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
        })
        totalHTML.innerText = totalQuantity;
    }

    // clear cart
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

    // event click
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
    })


    // Retain data even turn off computer/ browser
    const initApp = () => {
        // If shoppingCart data exits in client
        if (localStorage.getItem("cart")) {
            cart = JSON.parse(localStorage.getItem("cart"));
        }
        refreshCartHTML();
        populateSavedCardsDropdown();
    }
    initApp();
}




export default cart;
