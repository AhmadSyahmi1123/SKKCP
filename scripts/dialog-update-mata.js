// Dapatkan semua elemen yang membuka modal
const open_modal = document.querySelectorAll(".open-update-point");

// Dapatkan kontainer modal
const modal_container = document.getElementById("modal_mata_container");

// Dapatkan semua elemen yang menutup modal
const closed = document.querySelectorAll(".close-update-point");
const closeBtn = document.querySelectorAll(".closeMataBtn");

// Dapatkan semua butang yang mengedit mata
const openButtons = document.querySelectorAll(".editMataBtn");

// Tambah pendengar acara klik kepada setiap butang edit mata
openButtons.forEach(button => {
    button.addEventListener("click", () => {
        console.log("Clicked!");
        // Dapatkan nilai nokp daripada atribut data-nokp
        const nokp = button.dataset.nokp;

        // Masukkan nilai nokp ke dalam tindakan borang modal
        const modalForm = document.querySelector("#modal_mata_container form");
        modalForm.action = `mata-kemaskini-proses.php?nokp=${nokp}`;
    });
});

// Tambah pendengar acara klik kepada setiap butang yang membuka modal
open_modal.forEach(button => {
    button.addEventListener("click", () => {
        console.log("Open!");
        // Tunjukkan modal dengan menambah kelas 'show'
        modal_container.classList.add('show');
    });
});

// Tambah pendengar acara klik kepada setiap butang yang menutup modal
closed.forEach(button => {
    button.addEventListener("click", () => {
        // Sembunyikan modal dengan membuang kelas 'show'
        modal_container.classList.remove('show');
    });
});

// Tambah pendengar acara klik kepada setiap butang yang menutup modal (tambahan)
closeBtn.forEach(button => {
    button.addEventListener("click", () => {
        // Sembunyikan modal dengan membuang kelas 'show'
        modal_container.classList.remove('show');
    });
});
