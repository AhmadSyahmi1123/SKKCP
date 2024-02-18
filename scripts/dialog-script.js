const openD = document.getElementById("open-dialog");
const modal_container = document.getElementById("modal_container");
const closeD = document.getElementById("close-dialog");

openD.addEventListener('click', function() {
    modal_container.classList.add('show');
})

closeD.addEventListener('click', function() {
    modal_container.classList.remove('show');
})