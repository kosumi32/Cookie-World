document.addEventListener('DOMContentLoaded', function() {
    displayCards();
});

function displayCards() {
    let cards = JSON.parse(localStorage.getItem('cards')) || [];
    let savedCardsDiv = document.getElementById('savedCards');
    savedCardsDiv.innerHTML = '';

    if (cards.length === 0) {
        savedCardsDiv.innerHTML = '<p>No cards saved yet.</p>';
        return;
    }

    cards.forEach((card, index) => {
        let cardDiv = document.createElement('div');
        cardDiv.className = 'saved-card';

        cardDiv.innerHTML = `
            <div>
                <p><strong>${card.cardHolder}</strong></p>
            </div>
            <div>
                <p>${card.cardNumber}</p>
            </div>
            <div>
                <p>${card.expMonth}/${card.expYear}</p>
            </div>
            <div class='remove-card-btn'>
                <button onclick="removeCard(${index})">Remove</button>
            </div>
        `;

        savedCardsDiv.appendChild(cardDiv);
    });
}

function removeCard(index) {
    let cards = JSON.parse(localStorage.getItem('cards')) || [];
    cards.splice(index, 1);
    localStorage.setItem('cards', JSON.stringify(cards));
    displayCards();
}
