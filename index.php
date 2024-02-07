<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php
include("header.php");
?>

<div class="carousel-container">
    <i id="prev" class="fa-solid fa-angle-left"></i>
    <div class="carousel">
        <div class="slider">
            <section>
                <a href="">
                    <img src="img\btpmap.png" alt="">
                </a>
            </section>
            <section>
                <a href="signup-borang.php">
                    <img src="img\register-ad.jpeg" alt="">
                </a>
            </section>
        </div>
    </div>
    <i id="next" class="fa-solid fa-angle-right"></i>
</div>