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

// clock start

function updateClock() {
    var now = new Date();
    var dname = now.getDay(),
        mo = now.getMonth(),
        dnum = now.getDate(),
        yr = now.getFullYear(),
        hou = now.getHours(),
        min = now.getMinutes(),
        sec = now.getSeconds(),
        pe = "AM";

    if (hou == 0) {
        hou = 12;
    }
    if (hou > 12) {
        hou = hou - 12;
        pe = "PM";
    }

    Number.prototype.pad = function (digits) {
        return this.toString().padStart(digits, '0');
    }

    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var ids = ["dayname", "month", "daynum", "year", "hour", "minutes", "seconds", "period"];
    var values = [week[dname], months[mo], dnum.pad(2), yr, hou.pad(2), min.pad(2), sec.pad(2), pe];
    for (var i = 0; i < ids.length; i++) {
        document.getElementById(ids[i]).firstChild.nodeValue = values[i];
    }
}

function initClock() {
    updateClock();
    window.setInterval(updateClock, 1000);
}

// Call initClock on window load
window.onload = initClock;


// clock end
