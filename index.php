<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php
include("header.php");
?>

<div class="carousel-container">
    <div class="glide">
        <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides">
                <li class="glide__slide">
                    <a href="signup-borang.php"><img src="img\register-ad.jpeg" alt=""></a>
                </li>
                <li class="glide__slide"><img src="img\btpmap.png" alt=""></li>
                <li class="glide__slide"><img src="img\btpmap.png" alt=""></li>
                <li class="glide__slide"><img src="img\btpmap.png" alt=""></li>
                <li class="glide__slide"><img src="img\btpmap.png" alt=""></li>
            </ul>
        </div>
        <div class="glide__arrows" data-glide-el="controls">
            <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class='bx bx-chevron-left'></i></button>
            <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class='bx bx-chevron-right' ></i></button>
        </div>
    </div>
</div>
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