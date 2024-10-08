<?php
# Memulakan sesi pengguna
session_start();

# Memanggil fail header.php
include ("header.php");
?>

<div id="filter-overlay"></div>
<!-- Ruang kotak yang mengandungi komponen untuk pengguna mendaftar -->
<div class="wrapper-container">
    <div class="card wrapper login">
        <!-- Borang Daftar Masuk -->
        <form action="login-proses.php" method="POST">

            <!-- Tajuk Antaramuka Log Masuk -->
            <h1>Log Masuk</h1>

            <!-- Input untuk nombor kad pengenalan -->
            <label for="input-nama">Nombor Kad Pengenalan</label>
            <div class="input-box">
                <input type="text" name="nokp" placeholder="No. Kad Pengenalan" required>
                <i class='bx bx-hash'></i>
            </div>

            <!-- Input untuk katalaluan -->
            <label for="input-nama">Katalaluan</label>
            <div class="input-box">
                <input type="password" name='katalaluan' placeholder="Katalaluan" required>
                <i class="fas fa-eye password-toggle"></i>
            </div>

            <!-- Butang untuk menghantar borang log masuk -->
            <input class="btn" type='submit' value='Log Masuk'>

            <!-- Pautan bagi ahli yang belum mendaftar -->
            <div class="link-register">
                Bukan Ahli? <a href="signup-borang.php">Daftar Sini</a>
            </div>

        </form>
    </div>
</div>

<!-- Kaki laman (footer) -->
<footer class="default-footer">
    <div class="footer-container">
        <p class="copyright">Hakcipta &copy; 2023-2024: SKKPK SMK Bandar Tasik Puteri</p>
    </div>
</footer>

<!-- Skrip untuk fungsi toggle visibility password -->
<script src="scripts\password-visibility-toggle.js" defer></script>

<!-- fungsi mesra pengguna buta warna -->
<script src="scripts\colorblind.js" defer></script>

<!-- skrip paparan notifikasi maklumbalas -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="scripts\toast.js"></script>