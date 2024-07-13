// Variables to store the current font size and the range for the cycle
var currentSize = 18;

function ubahsaiz(gandaan) {
    // Get the element whose font size we want to change
    var saiz = document.getElementById("saiz");

    // Check if the reset button was pressed
    if (gandaan == 2) {
        saiz.style.fontSize = "18px";
    }
    else {
        currentSize += gandaan;
        saiz.style.fontSize = currentSize + "px";
    }
}
