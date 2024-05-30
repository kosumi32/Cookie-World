$(document).ready(function(){
    $('.header').height($(window).height());
})

document.getElementById('cardNumberInput').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\s+/g, '');
    let formattedValue = '';
    
    for (let i = 0; i < value.length; i += 4) {
        if (i > 0) formattedValue += ' ';
        formattedValue += value.substring(i, i + 4);
    }
    
    e.target.value = formattedValue;
});

document.querySelector('.card-number-input').oninput = () =>{
    document.querySelector('.card-number-box').innerText = document.querySelector('.card-number-input').value;
}

document.querySelector('.card-holder-input').oninput = () =>{
    document.querySelector('.card-holder-name').innerText = document.querySelector('.card-holder-input').value;
}

document.querySelector('.month-input').oninput = () =>{
    document.querySelector('.exp-month').innerText = document.querySelector('.month-input').value;
}

document.querySelector('.year-input').oninput = () =>{
    document.querySelector('.exp-year').innerText = document.querySelector('.year-input').value;
}

document.querySelector('.cvv-input').onmouseenter = () =>{
    document.querySelector('.front').style.transform = 'perspective(1000px) rotateY(-180deg)';
    document.querySelector('.back').style.transform = 'perspective(1000px) rotateY(0deg)';
}

document.querySelector('.cvv-input').onmouseleave = () =>{
    document.querySelector('.front').style.transform = 'perspective(1000px) rotateY(0deg)';
    document.querySelector('.back').style.transform = 'perspective(1000px) rotateY(180deg)';
}

document.querySelector('.cvv-input').oninput = () =>{
    document.querySelector('.cvv-box').innerText = document.querySelector('.cvv-input').value;
}

document.getElementById('cardForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let cardNumber = document.querySelector('.card-number-input').value;
    let cardHolder = document.querySelector('.card-holder-input').value;
    let expMonth = document.querySelector('.month-input').value;
    let expYear = document.querySelector('.year-input').value;
    let cvv = document.querySelector('.cvv-input').value;

    let cardDetails = {
        cardNumber: cardNumber,
        cardHolder: cardHolder,
        expMonth: expMonth,
        expYear: expYear,
        cvv: cvv
    };

    saveCard(cardDetails);
});

function saveCard(card) {
    let cards = JSON.parse(localStorage.getItem('cards')) || [];
    cards.push(card);
    localStorage.setItem('cards', JSON.stringify(cards));
}