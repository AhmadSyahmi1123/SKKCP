function printPage() {
    // Dapatkan kandungan jadual yang boleh tatal
    var tableContent = document.querySelector('.scrollable-table table').outerHTML;

    // Buka tetingkap baru untuk pencetakan
    var printWindow = window.open('', '_blank');

    // Tulis kandungan jadual ke dalam tetingkap baru
    printWindow.document.write('<html><head><title>Print</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; }');
    printWindow.document.write('table { border-collapse: collapse; width: 100%; }');
    printWindow.document.write('th, td { border: 1px solid black; padding: 8px; text-align: left; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('.profile_img_list { display:none; }');
    printWindow.document.write('.td-name { display: inline-block; vertical-align: middle; }');
    printWindow.document.write('.action-container, .editBtn, .deleteBtn { display: none; }'); // Sembunyikan butang tindakan semasa cetak
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write(tableContent);
    printWindow.document.write('</body></html>');

    printWindow.document.close();

    // Fokus pada tetingkap baru
    printWindow.focus();

    // Fungsi untuk mengendalikan cetakan
    function handlePrint() {
        printWindow.print();

        // Tutup tetingkap selepas sedikit masa
        printWindow.close();
    }

    // Panggil handlePrint selepas sedikit masa untuk memastikan kandungan dimuatkan
    setTimeout(handlePrint, 100);
}
