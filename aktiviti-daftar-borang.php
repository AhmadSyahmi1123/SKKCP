<?php
# Memulakan sesi PHP untuk menyimpan maklumat pengguna
session_start();

# Memanggil fail header.php untuk antaramuka pengguna dan kawalan-admin.php untuk fungsi kawalan
include ("header.php");
include ("kawalan-admin.php");
?>

<div id="filter-overlay"></div>
<main>
    <!-- Borang untuk menerima data aktiviti baharu daripada pengguna -->
    <div class="wrapper">
        <!-- Borang Daftar Aktiviti -->
        <form action='aktiviti-daftar-proses.php' method="POST">

            <!-- Tajuk Antaramuka Borang Daftar Aktiviti -->
            <h1>Daftar Aktiviti Baru</h1>

            <!-- Input untuk Nama Aktiviti -->
            <label for="input-aktiviti">Nama Aktiviti*</label>
            <div class="input-box">
                <input id="input-aktiviti" type='text' name='nama_aktiviti' placeholder="Nama Aktiviti" required><br>
            </div>

            <!-- Input untuk Tarikh Aktiviti -->
            <label for="input-tarikh">Tarikh Aktiviti*</label>
            <div class="input-box">
                <input id="input-tarikh" type='date' name='tarikh_aktiviti' min='<?= date("Y-m-d") ?>' required><br>
            </div>

            <!-- Input untuk Masa Mula Aktiviti -->
            <label for="input-masa">Masa Mula*</label>
            <div class="input-box">
                <input id="input-masa" type='time' name='masa_mula' placeholder="Masa Mula" required><br>
            </div>

            <!-- Input untuk Masa Tamat Aktiviti -->
            <label for="input-masa">Masa Tamat*</label>
            <div class="input-box">
                <input id="input-masa" type='time' name='masa_tamat' placeholder="Masa Tamat" required><br>
            </div>

            <!-- Butang untuk menghantar borang -->
            <input class="btn" type='submit' value='Tambah'>

        </form>
    </div>
</main>

<footer class="default-footer">
    <div class="footer-container">
        <p class="copyright">Hakcipta &copy; 2023-2024: SKKPK SMK Bandar Tasik Puteri</p>
    </div>
</footer>

<!-- Skrip untuk fungsi mesra pengguna buta warna -->
<script src="scripts\colorblind.js" defer></script>