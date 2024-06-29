$(document).ready(function(){
    $('.header').height($(window).height());
});

document.getElementById('cardNumberInput').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\s+/g, '');
    let formattedValue = '';
    
    for (let i = 0; i < value.length; i += 4) {
        if (i > 0) formattedValue += ' ';
        formattedValue += value.substring(i, i + 4);
    }
    
    e.target.value = formattedValue;
});

document.querySelector('.card-number-input').oninput = () => {
    document.querySelector('.card-number-box').innerText = document.querySelector('.card-number-input').value;
};

document.querySelector('.card-holder-input').oninput = () => {
    document.querySelector('.card-holder-name').innerText = document.querySelector('.card-holder-input').value;
};

document.querySelector('.month-input').oninput = () => {
    document.querySelector('.exp-month').innerText = document.querySelector('.month-input').value;
};

document.querySelector('.year-input').oninput = () => {
    document.querySelector('.exp-year').innerText = document.querySelector('.year-input').value;
};

document.querySelector('.cvv-input').oninput = () => {
    document.querySelector('.cvv-box').innerText = document.querySelector('.cvv-input').value;
};

document.querySelector('.cvv-input').onmouseenter = () => {
    document.querySelector('.front').style.transform = 'perspective(1000px) rotateY(-180deg)';
    document.querySelector('.back').style.transform = 'perspective(1000px) rotateY(0deg)';
};

document.querySelector('.cvv-input').onmouseleave = () => {
    document.querySelector('.front').style.transform = 'perspective(1000px) rotateY(0deg)';
    document.querySelector('.back').style.transform = 'perspective(1000px) rotateY(180deg)';
};

// Mouse trailer
const coords = { x: 0, y: 0 };
const trailers = document.querySelectorAll(".trailer");

trailers.forEach(function(trailer) {
    trailer.x = 0;
    trailer.y = 0;
    trailer.style.opacity = 0; // Initially hidden
});

window.addEventListener("mousemove", function(e) {
    coords.x = e.clientX;
    coords.y = e.clientY;
    trailers.forEach(trailer => {
        trailer.style.opacity = 1; // Make trailers visible when the mouse is moving
    });
});

// Using `mouseout` on document to capture when mouse leaves the window
document.addEventListener("mouseout", function(e) {
    if (!e.relatedTarget || e.relatedTarget.nodeName === "HTML") {
        trailers.forEach(trailer => {
            trailer.style.opacity = 0; // Make trailers invisible when the mouse leaves the page
        });
    }
});

function animateTrailers() {
    let x = coords.x;
    let y = coords.y;
    
    trailers.forEach(function(trailer, index) {
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
