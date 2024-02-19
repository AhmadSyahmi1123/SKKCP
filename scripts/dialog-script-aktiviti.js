const open = document.getElementById("open-aktiviti");
const modal_container = document.getElementById("modal_aktiviti_container");
const closed = document.getElementById("close-aktiviti");
const closeBtn = document.querySelector(".closeBtn");

open.addEventListener('click', function () {
    modal_container.classList.add('show');
})

closed.addEventListener('click', function () {
    modal_container.classList.remove('show');
})

closeBtn.addEventListener('click', function () {
    modal_container.classList.remove('show');
})