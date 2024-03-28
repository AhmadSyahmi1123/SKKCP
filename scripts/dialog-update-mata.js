const open_modal = document.querySelectorAll(".open-update-point");
const modal_container = document.getElementById("modal_mata_container");
const closed = document.querySelectorAll(".close-update-point");
const closeBtn = document.querySelectorAll(".closeMataBtn");

// Add click event listener to each button
const openButtons = document.querySelectorAll(".editMataBtn");

// Add click event listener to each button
openButtons.forEach(button => {
    button.addEventListener("click", () => {
        console.log("Clicked!");
        // Dapatkan nilai nokp daripada atribut data-nokp
        const nokp = button.dataset.nokp;

        // Masukkan nilai nokp ke dalam tindakan borang
        const modalForm = document.querySelector("#modal_mata_container form");
        modalForm.action = `mata-kemaskini-proses.php?nokp=${nokp}`;
    });
});
open_modal.forEach(button => {
    button.addEventListener("click", () => {
        console.log("Open!");
        modal_container.classList.add('show');
    });
});

closed.forEach(button => {
    button.addEventListener("click", () => {
        modal_container.classList.remove('show');
    });
});

closeBtn.forEach(button => {
    button.addEventListener("click", () => {
        modal_container.classList.remove('show');
    });
});