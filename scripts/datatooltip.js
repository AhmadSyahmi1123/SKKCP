// Tunggu sehingga dokumen dimuatkan sepenuhnya sebelum menjalankan kod
document.addEventListener('DOMContentLoaded', function () {
    // Pilih semua elemen yang mempunyai atribut data-tooltip
    const tooltipElements = document.querySelectorAll('[data-tooltip]');

    // Untuk setiap elemen yang mempunyai atribut data-tooltip
    tooltipElements.forEach(element => {
        // Tambah pengendali acara untuk 'mouseenter'
        element.addEventListener('mouseenter', function () {
            // Cipta elemen div untuk tooltip
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip'; // Tetapkan kelas CSS untuk tooltip
            tooltip.textContent = this.getAttribute('data-tooltip'); // Ambil teks tooltip dari atribut

            // Tambah tooltip ke dalam badan dokumen
            document.body.appendChild(tooltip);

            // Dapatkan posisi elemen yang memaparkan tooltip
            const rect = this.getBoundingClientRect();
            // Tetapkan posisi tooltip berdasarkan elemen
            tooltip.style.left = rect.left + 'px';
            tooltip.style.top = (rect.top - tooltip.offsetHeight) + 'px';
        });

        // Tambah pengendali acara untuk 'mouseleave'
        element.addEventListener('mouseleave', function () {
            // Cari dan buang tooltip apabila tetikus meninggalkan elemen
            const tooltip = document.querySelector('.tooltip');
            if (tooltip) {
                tooltip.remove();
            }
        });
    });
});
