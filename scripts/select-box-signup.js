// Inisialisasi Select2 pada elemen dengan ID "select-box-kelas"
$("#select-box-kelas").select2({
    placeholder: "Sila Pilih Kelas", // Teks placeholder dalam kotak pilih
    containerCssClass: "select2-dark-container", // Kelas CSS untuk container
    dropdownCssClass: "select2-dark-dropdown" // Kelas CSS untuk dropdown
});

// Gaya untuk elemen pilihan Select2
$('.select2-selection').css({
    'font-size': '16px', // Saiz font
    'height': '40px', // Ketinggian kotak pilih
    'margin-top': '5px', // Margin atas
    'padding-top': '5px', // Padding atas
    'padding-left': '10px', // Padding kiri
    'background-color': '#26272b', // Warna latar belakang
    'border': '2px solid var(--accent-color)', // Warna dan lebar sempadan
    'border-radius': '6px', // Radius sudut
    'transition': 'border .2s ease-in-out' // Transisi perubahan sempadan
});

// Gaya untuk teks yang dipaparkan dalam elemen pilihan Select2
$('.select2-selection__rendered').css('color', '#fcfcfc'); // Warna teks

// Gaya untuk anak panah dalam elemen pilihan Select2
$('.select2-selection__arrow').css('margin-top', '10px'); // Margin atas anak panah
$('.select2-selection__arrow').css('margin-right', '15px'); // Margin kanan anak panah

// Gaya tema gelap untuk Select2
var darkThemeStyles = `
    .select2-dark-container {
        background-color: #26272b; // Warna latar belakang container
    }
    .select2-dark-container .select2-selection--single {
        background-color: #26272b; // Warna latar belakang untuk pilihan tunggal
        color: #fff; // Warna teks
    }
    .select2-dark-container .select2-selection--single .select2-selection__placeholder {
        color: #999; // Warna placeholder
    }
    .select2-dark-dropdown .select2-results__option {
        background-color: #26272b; // Warna latar belakang untuk pilihan dropdown
        color: #fff; // Warna teks untuk pilihan dropdown
        padding-left: 20px; // Padding kiri untuk pilihan dropdown
    }
    .select2-dark-dropdown .select2-results__option--highlighted {
        background-color: #555; // Warna latar belakang untuk pilihan yang disorot
        color: #fff; // Warna teks untuk pilihan yang disorot
    }
`;

// Tambah elemen style baru dan tambah ke head dokumen
var styleElement = document.createElement('style');
styleElement.innerHTML = darkThemeStyles; // Tetapkan gaya ke elemen style
document.head.appendChild(styleElement); // Tambah elemen style ke head dokumen

// Tukar warna sempadan apabila dropdown dibuka
$('#select-box-kelas').on('select2:open', function (e) {
    $('#select-box-kelas').next('.select2-container').find('.select2-selection').css('border-color', 'var(--accent3-color)'); // Tukar kepada warna sempadan yang dikehendaki
});

// Tukar warna sempadan apabila dropdown ditutup
$('#select-box-kelas').on('select2:close', function (e) {
    $('#select-box-kelas').next('.select2-container').find('.select2-selection').css('border-color', 'var(--accent-color)'); // Tukar semula kepada warna sempadan asal
});
