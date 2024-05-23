import cart from "./cart.js";

// Get product data
import products from "./products.js";

let app = document.getElementById("app");
let temporaryContent = document.getElementById("temporaryContent");

// Load template file
const loadTemplate = () => {
    fetch('template.html')
    .then(response => response.text())
    .then(html => {
        app.innerHTML = html;

        // Push data of current page to the center (content in template file)
        let contentTab = document.getElementById("contentTab");
        contentTab.innerHTML = temporaryContent.innerHTML;
        temporaryContent.innerHTML = null;
        cart();
        initApp();
    })
}

loadTemplate();

const initApp = () => {
    // load product list
    let listProduct = document.querySelector(".listProduct");
    listProduct.innerHTML = null;
    products.forEach(product => {
        let newProduct = document.createElement("div");
        newProduct.classList.add("item");
        newProduct.innerHTML = 
         `<a href="/detail.html?id=${product.id}">
             <img src="${product.image}">
         </a>
         <h2>${product.name}</h2>
         <div class="price">$${product.price}</div>
         <button 
             class="addCart" 
             data-id='${product.id}'>
                 Add To Cart
         </button>`;
        listProduct.appendChild(newProduct);
    })
}