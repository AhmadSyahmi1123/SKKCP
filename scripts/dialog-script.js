// Dapatkan elemen-elemen yang diperlukan dari DOM
const openD = document.getElementById("open-dialog"); // Butang untuk membuka dialog
const modal_container = document.getElementById("modal_container"); // Kontainer modal
const closeD = document.getElementById("close-dialog"); // Butang untuk menutup dialog

// Tambah pengendali acara untuk butang buka dialog
openD.addEventListener('click', function () {
    // Tambah kelas 'show' kepada kontainer modal untuk memaparkannya
    modal_container.classList.add('show');
})

// Tambah pengendali acara untuk butang tutup dialog
closeD.addEventListener('click', function () {
    // Buang kelas 'show' daripada kontainer modal untuk menyembunyikannya
    modal_container.classList.remove('show');
})
