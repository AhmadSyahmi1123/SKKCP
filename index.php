<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php
include ("header.php");
?>

<div id="filter-overlay"></div>
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
        <div class="glide__arrows" data-glide-el="controls">
            <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i
                    class='bx bx-chevron-left'></i></button>
            <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i
                    class='bx bx-chevron-right'></i></button>
        </div>
    </div>
</div>

<footer class="default-footer">
    <div class="footer-container">
        <p class="copyright">Hakcipta &copy; 2023-2024: SKKPK SMK Bandar Tasik
            Puteri</p>
    </div>
</footer>

<!-- fungsi mesra pengguna buta warna -->
<script src="scripts\colorblind.js" defer></script>

<script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>
<script>
    const config = {
        type: 'carousel',
        perView: 2,
        focusAt: 'center',
        gap: 10,
        autoplay: 2000,
        hoverPause: true,
        dragThreshold: false,
        animationTimingFunc: 'ease'
    }
    new Glide('.glide', config).mount()
</script>