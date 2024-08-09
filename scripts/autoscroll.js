// Fungsi autoscroll ke leaderboard
function scrollToElement() {
    var element = document.querySelector(".leaderboard");
    if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
    }
}

// scroll ke bawah "on load"
window.addEventListener('load', scrollToElement);