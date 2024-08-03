// Dapatkan elemen-elemen yang diperlukan dari DOM
const open = document.getElementById("open-aktiviti"); // Butang untuk membuka modal
const modal_container = document.getElementById("modal_aktiviti_container"); // Kontainer modal
const closeBtn = document.getElementById("closeAddAktivitiBtn"); // Butang untuk menutup modal

// Tambah pengendali acara untuk butang buka modal
open.addEventListener('click', function () {
    // Tambah kelas 'show' kepada kontainer modal untuk memaparkannya
    modal_container.classList.add('show');
});

// Tambah pengendali acara untuk butang tutup modal
closeBtn.addEventListener('click', function () {
    // Buang kelas 'show' daripada kontainer modal untuk menyembunyikannya
    modal_container.classList.remove('show');
});
