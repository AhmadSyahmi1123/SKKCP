// Senarai penapis buta warna
const filters = ['protanopia', 'deuteranopia', 'tritanopia', 'achromatopsia', ''];
const filterOverlay = document.getElementById('filter-overlay');

// Tunggu hingga dokumen dimuatkan sepenuhnya sebelum menjalankan kod
document.addEventListener('DOMContentLoaded', () => {
    let currentFilterIndex = 0; // Indeks penapis semasa

    // Fungsi untuk menerapkan penapis
    function applyFilter() {
        if (filters[currentFilterIndex] === '') {
            // Jika tiada penapis, sembunyikan overlay
            filterOverlay.style.display = 'none';
        } else {
            // Jika penapis ada, paparkan overlay dan tetapkan kelas
            filterOverlay.style.display = 'block';
            filterOverlay.className = filters[currentFilterIndex];
        }
        // Simpan indeks penapis semasa dalam localStorage
        localStorage.setItem('colorBlindnessFilter', currentFilterIndex);
    }

    // Fungsi untuk menukar penapis kepada yang seterusnya dalam senarai
    function toggleFilter() {
        currentFilterIndex = (currentFilterIndex + 1) % filters.length;
        applyFilter();
    }

    // Fungsi untuk memuatkan penapis yang disimpan dari localStorage
    function loadFilter() {
        const savedFilterIndex = localStorage.getItem('colorBlindnessFilter');
        if (savedFilterIndex !== null) {
            currentFilterIndex = parseInt(savedFilterIndex, 10);
            applyFilter();
        }
    }

    // Fungsi untuk menetapkan penapis kepada tiada (kosong)
    function resetFilter() {
        currentFilterIndex = filters.length - 1; // Tetapkan kepada indeks string kosong
        applyFilter();
    }

    // Muatkan penapis yang disimpan semasa memuatkan halaman
    loadFilter();

    // Eksport fungsi untuk digunakan dalam HTML
    window.toggleFilter = toggleFilter;
    window.resetFilter = resetFilter;
});
