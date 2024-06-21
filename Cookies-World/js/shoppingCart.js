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
         `<a href="detail.html?id=${product.id}">
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

// mouse trailer
const coords = { x: 0, y: 0 };
const trailers = document.querySelectorAll(".trailer");

trailers.forEach(function (trailer) {
    trailer.x = 0;
    trailer.y = 0;
    trailer.style.opacity = 0; // Initially hidden
});

window.addEventListener("mousemove", function (e) {
    coords.x = e.clientX;
    coords.y = e.clientY;
    trailers.forEach(trailer => {
        trailer.style.opacity = 1; // Make trailers visible when the mouse is moving
    });
});

// Using `mouseout` on document to capture when mouse leaves the window
document.addEventListener("mouseout", function (e) {
    if (!e.relatedTarget || e.relatedTarget.nodeName === "HTML") {
        trailers.forEach(trailer => {
            trailer.style.opacity = 0; // Make trailers invisible when the mouse leaves the page
        });
    }
});

function animateTrailers() {
    let x = coords.x;
    let y = coords.y;

    trailers.forEach(function (trailer, index) {
        trailer.style.left = x - trailer.offsetWidth / 2 + "px";
        trailer.style.top = y - trailer.offsetHeight / 2 + "px";

        // Scale effect based on position in the list
        trailer.style.transform = `scale(${(trailers.length - index) / 10})`;

        // Update trailer coordinates
        trailer.x = x;
        trailer.y = y;

        // Calculate the new position for the next trailer
        const nextTrailer = trailers[index + 1] || trailers[0];
        x += (nextTrailer.x - x) * 0.5;
        y += (nextTrailer.y - y) * 0.5;
    });

    requestAnimationFrame(animateTrailers);
}

animateTrailers();
