const open = document.getElementById("open-aktiviti");
const modal_container = document.getElementById("modal_aktiviti_container");
const closeBtn = document.getElementById("closeAddAktivitiBtn");

open.addEventListener('click', function () {
    modal_container.classList.add('show');
})

closeBtn.addEventListener('click', function () {
    modal_container.classList.remove('show');
})