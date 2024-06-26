<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php
include ("header.php");
?>

<!-- Ruang kotak yang mengandungi komponen untuk pengguna mendaftar -->
<div class="wrapper-container">
    <div class="card wrapper">
        <!-- Borang Daftar Masuk -->
        <form action="login-proses.php" method="POST">

            <!-- Tajuk Antaramuka Log Masuk -->
            <h1>Log Masuk</h1>

            <div class="input-box">
                <input type="text" name="nokp" placeholder="No. Kad Pengenalan" required>
                <i class='bx bx-hash'></i>
            </div>

            <div class="input-box">
                <input type="password" name='katalaluan' placeholder="Katalaluan" required>
                <i class="fas fa-eye password-toggle"></i>
            </div>

            <input class="btn" type='submit' value='Log Masuk'>

            <div class="link-register">
                Bukan Ahli? <a href="signup-borang.php">Daftar Sini</a>
            </div>

        </form>
    </div>
</div>
<script src="scripts\autoscroll.js" defer></script>
<script src="scripts\password-visibility-toggle.js" defer></script>

<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="scripts\toast.js"></script>