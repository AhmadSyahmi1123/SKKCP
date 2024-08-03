// Dapatkan elemen-elemen yang diperlukan dari DOM
const open = document.getElementById("open-upload"); // Butang untuk membuka modal muat naik
const modal_container = document.getElementById("modal_upload_container"); // Kontainer modal muat naik
const closed = document.getElementById("close-upload"); // Butang untuk menutup modal muat naik
const closeBtn = document.getElementById("closeUploadFileBtn"); // Butang tambahan untuk menutup modal muat naik

// Tambah pengendali acara untuk butang buka modal
open.addEventListener('click', function () {
    // Tambah kelas 'show' kepada kontainer modal untuk memaparkannya
    modal_container.classList.add('show');
});

// Tambah pengendali acara untuk butang tutup modal
closed.addEventListener('click', function () {
    // Buang kelas 'show' daripada kontainer modal untuk menyembunyikannya
    modal_container.classList.remove('show');
});

// Tambah pengendali acara untuk butang tutup tambahan
closeBtn.addEventListener('click', function () {
    // Buang kelas 'show' daripada kontainer modal untuk menyembunyikannya
    modal_container.classList.remove('show');
});
