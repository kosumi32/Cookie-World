// Get the modal
var modal = document.getElementById("myModal");

// Get the remove card button
var removeCardBtn = document.getElementById("removeCardBtn");

// Get the Yes and No buttons inside the modal
var btnYes = document.getElementById("btnYes");
var btnNo = document.getElementById("btnNo");

// When the user clicks the remove card button, open the modal 
removeCardBtn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on Yes, submit the form
btnYes.onclick = function() {
    document.getElementById("removeCardForm").submit();
}

// When the user clicks on No, close the modal
btnNo.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}