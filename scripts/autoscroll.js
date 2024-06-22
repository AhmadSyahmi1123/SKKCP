// Function to scroll to the target element
function scrollToElement() {
    var element = document.querySelector(".wrapper-container");
    if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
    }
}

// Add an event listener to scroll when the page loads
window.addEventListener('load', scrollToElement);