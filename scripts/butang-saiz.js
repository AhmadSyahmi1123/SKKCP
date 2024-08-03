// Pemboleh ubah untuk menyimpan saiz fon semasa
var currentSize = 18;

// Fungsi untuk mengubah saiz fon
function ubahsaiz(gandaan) {
    // Dapatkan elemen yang saiz fon nya ingin diubah
    var saiz = document.getElementById("saiz");

    // Semak jika butang reset ditekan
    if (gandaan == 2) {
        // Tetapkan saiz fon kepada saiz asal (18px) jika reset
        saiz.style.fontSize = "18px";
    }
    else {
        // Tambah gandaan kepada saiz fon semasa dan kemas kini
        currentSize += gandaan;
        saiz.style.fontSize = currentSize + "px";
    }
}
