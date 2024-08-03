// Mengambil data mata pengguna dari server
fetch('get-mata-pengguna.php')
    .then(response => response.json())  // Menukarkan respons kepada format JSON
    .then(data => {
        console.log(data);  // Papar data di konsol untuk tujuan penyemakan
        let userPoints = data.mata;  // Ambil jumlah mata pengguna daripada data
        updateProgressBar(userPoints);  // Kemas kini bar kemajuan dengan mata pengguna
    });

let currentPoints;  // Pembolehubah untuk menyimpan mata semasa
let maxPointsAllowed = 1000;  // Mata maksimum yang dibenarkan

function updateProgressBar(points) {

    currentPoints = points;  // Kemas kini mata semasa

    // Inisialisasi ProgressBar.Circle untuk bar kemajuan
    var bar = new ProgressBar.Circle("#view-mata", {
        strokeWidth: 6,  // Lebar garis stroke
        easing: 'easeInOut',  // Jenis easing untuk animasi
        duration: 1000,  // Tempoh animasi dalam milisaat
        color: 'var(--button-secondary-color)',  // Warna bar kemajuan
        trailColor: '#adadad',  // Warna laluan latar belakang
        trailWidth: 6,  // Lebar garis laluan latar belakang
        svgStyle: null,  // Gaya SVG tambahan
        strokeLinecap: 'round'  // Bentuk hujung garis stroke
    });

    // Tetapkan teks bar kemajuan kepada mata pengguna
    bar.setText(currentPoints + "\nmata");
    bar.text.style.fontSize = "4rem";  // Saiz font untuk teks
    // Animasikan bar kemajuan berdasarkan nisbah mata pengguna dan mata maksimum
    bar.animate((currentPoints / maxPointsAllowed));
}
