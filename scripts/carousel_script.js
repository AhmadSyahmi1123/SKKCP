const slider = document.querySelector(".slider");
const carousel = document.querySelector(".carousel");

const prev = document.querySelector("#prev");
const next = document.querySelector("#next");

var direction;

let autoplayTimeout;
let resumeTimeout;

prev.addEventListener('click', function () {
    pauseAutoplay();

    if (direction === -1) {
        slider.appendChild(slider.firstElementChild);
        direction = 1;
    }

    carousel.style.justifyContent = 'flex-end';
    slider.style.transform = 'translate(50%)';
})

next.addEventListener('click', function () {

    direction = -1;
    carousel.style.justifyContent = 'flex-start';
    slider.style.transform = 'translate(-50%)';
})

slider.addEventListener('transitionend', function () {
    if (direction === -1) {
        slider.appendChild(slider.firstElementChild);
    }
    else if (direction === 1) {
        slider.prepend(slider.lastElementChild);
    }

    slider.style.transition = 'none';
    slider.style.transform = 'translate(0)';
    setTimeout(function () {
        slider.style.transition = 'all 0.5s';
    })
})

function autoPlay() {
    next.click();
    console.log("Autoplaying...");
    autoplayTimeout = setTimeout(autoPlay, 3000);
}

function pauseAutoplay() {
    console.log("Paused");
    clearTimeout(autoplayTimeout);
}

function resumeAutoplay() {
    clearTimeout(resumeTimeout);
    resumeTimeout = setTimeout(() => {
        autoPlay();
    }, 2000); // 2 second delay 
}

autoPlay();

prev.addEventListener("mouseenter", pauseAutoplay);
prev.addEventListener("mouseleave", resumeAutoplay);
next.addEventListener("mouseenter", pauseAutoplay);
next.addEventListener("mouseleave", resumeAutoplay);