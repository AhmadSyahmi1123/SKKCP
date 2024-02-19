const open = document.getElementById("open-upload");
const modal_container = document.getElementById("modal_upload_container");
const closed = document.getElementById("close-upload");
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