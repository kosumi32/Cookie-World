const coords = { x: 0, y: 0 };
const trailers = document.querySelectorAll(".trailer");

trailers.forEach(function (trailer) {
    trailer.x = 0;
    trailer.y = 0;
    trailer.style.opacity = 0;
});

window.addEventListener("mousemove", function (e) {
    coords.x = e.clientX;
    coords.y = e.clientY;
    trailers.forEach(trailer => {
        trailer.style.opacity = 1;
    });
});

document.addEventListener("mouseout", function (e) {
    if (!e.relatedTarget || e.relatedTarget.nodeName === "HTML") {
        trailers.forEach(trailer => {
            trailer.style.opacity = 0;
        });
    }
});

function animateTrailers() {
    let x = coords.x;
    let y = coords.y;
    
    trailers.forEach(function (trailer, index) {
        trailer.style.left = x - trailer.offsetWidth / 2 + "px";
        trailer.style.top = y - trailer.offsetHeight / 2 + "px";
        trailer.style.transform = `scale(${(trailers.length - index) / 10})`;
        
        trailer.x = x;
        trailer.y = y;
        
        const nextTrailer = trailers[index + 1] || trailers[0];
        x += (nextTrailer.x - x) * 0.5;
        y += (nextTrailer.y - y) * 0.5;
    });
    
    requestAnimationFrame(animateTrailers);
}

animateTrailers();
