// Variables to store the current font size and the range for the cycle
var currentSize = 18;
const minSize = 18; // Minimum font size in em
const maxSize = 28;   // Maximum font size in em
const step = 2;    // Step size for each change in em

function ubahsaiz(gandaan) {
    // Get the element whose font size we want to change
    var saiz = document.getElementById("saiz");

    // Check if the reset button was pressed
    if (gandaan == 2) {
        currentSize = minSize;
        saiz.style.fontSize = currentSize + "px";
        return;
    }

    // Update the font size based on the current state
    currentSize += step;
    if (currentSize > maxSize) {
        currentSize = minSize; // Reset to minimum size
    }

    // Apply the new font size
    saiz.style.fontSize = currentSize + "px";
}

// Example usage: Attach these functions to buttons with onclick attributes
// <button onclick="ubahsaiz(1)">Change Size</button>
// <button onclick="ubahsaiz(2)">Reset Size</button>
