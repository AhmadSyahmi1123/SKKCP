<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php
include ("header.php");
?>

<div id="filter-overlay"></div>

<!-- Konten untuk carousel -->
<div class="carousel-container">
    <div class="glide">
        <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides">
                <li class="glide__slide">
                    <a href="signup-borang.php"><img src="img\daftar.png" alt=""></a>
                </li>
                <li class="glide__slide">
                    <a href="https://www.ppkomp.com.my/2023-pertandingan.htm"><img src="img\poster2.png" alt=""></a>
                </li>
                <li class="glide__slide">
                    <a href="https://www.hackerrank.com/"><img src="img\hackerrank.png" alt=""></a>
                </li>
                <li class="glide__slide">
                    <a href="https://www.codewars.com/dashboard"><img src="img\codewars.png" alt=""></a>
                </li>
                <li class="glide__slide">
                    <a href="https://codeforces.com/"><img src="img\codeforces.png" alt=""></a>
                </li>
            </ul>
        </div>

        <!-- Butang navigasi carousel -->
        <div class="glide__arrows" data-glide-el="controls">
            <button class="glide__arrow glide__arrow--left" data-glide-dir="<">
                <i class='bx bx-chevron-left'></i>
            </button>
            <button class="glide__arrow glide__arrow--right" data-glide-dir=">">
                <i class='bx bx-chevron-right'></i>
            </button>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="default-footer">
    <div class="footer-container">
        <p class="copyright">Hakcipta &copy; 2023-2024: SKKPK SMK Bandar Tasik Puteri</p>
    </div>
</footer>

<!-- Skrip untuk fungsi mesra pengguna buta warna -->
<script src="scripts\colorblind.js" defer></script>

<!-- Skrip Glide.js untuk carousel -->
<script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>
<script>
    const config = {
        type: 'carousel',          // Jenis carousel
        perView: 2,                // Bilangan slide yang dipaparkan dalam satu masa
        focusAt: 'center',         // Fokus pada slide tengah
        gap: 10,                   // Jarak antara slide
        autoplay: 2000,            // Auto main setiap 2000ms (2 saat)
        hoverPause: true,          // Jeda auto main apabila hover pada carousel
        dragThreshold: false,      // Disable drag
        animationTimingFunc: 'ease'// Fungsi masa untuk animasi
    }
    new Glide('.glide', config).mount()
</script>