<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php
include("header.php");
?>

<!-- Ruang kotak yang mengandungi komponen untuk pengguna mendaftar -->
<div class="wrapper">

    <!-- Borang Daftar Masuk -->
    <form action="login-proses.php" method="POST">

        <!-- Tajuk Antaramuka Log Masuk -->
        <h1>Log Masuk</h1>

        <div class="input-box"z>
            <input type="text" name="nokp" placeholder="No. Kad Pengenalan" required>
            <i class='bx bx-hash'></i>
        </div>

        <div class="input-box">
            <input type="password" name='katalaluan' placeholder="Katalaluan" required>
            <i class="fas fa-lock password-toggle"></i>
        </div>

        <input class="btn" type='submit' value='Log Masuk'>

        <div class="link-register">
            Bukan Ahli? <a href="signup-borang.php">Daftar Sini</a>
        </div>

    </form>
</div>
<script src="scripts\password-visibility-toggle.js" defer></script>