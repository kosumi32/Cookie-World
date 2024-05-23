// Toggle favorite button color
var btnvar1 = document.getElementById('btn1');
function Toggle1() {
    if (btnvar1.style.color == "gold") {
        btnvar1.style.color = "grey";
    } else {
        btnvar1.style.color = "gold";
    }
}

// Handle quantity increment and decrement
document.addEventListener('DOMContentLoaded', function () {
    const quantities = document.querySelectorAll('.quantity');

    quantities.forEach(quantity => {
        const minusButton = quantity.querySelector('.minus');
        const plusButton = quantity.querySelector('.plus');
        const quantityValue = quantity.querySelector('.quantity-value');

        minusButton.addEventListener('click', function () {
            let currentValue = parseInt(quantityValue.textContent);
            if (currentValue > 0) { // Prevent the value from going below 0
                quantityValue.textContent = currentValue - 1;
            }
        });

        plusButton.addEventListener('click', function () {
            let currentValue = parseInt(quantityValue.textContent);
            quantityValue.textContent = currentValue + 1;
        });
    });
});