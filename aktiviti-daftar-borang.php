<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php dan kawalan-admin.php
include("header.php");
include("kawalan-admin.php");
?>
<main>

    <!-- Borang untuk menerima data aktiviti baharu daripada pengguna -->
    <div class="wrapper">
        <!-- Borang Daftar Masuk -->
        <form action='aktiviti-daftar-proses.php' method="POST">

            <!-- Tajuk Antaramuka Log Masuk -->
            <h1>Daftar Aktiviti Baru</h1>

            <label for="input-aktiviti">Nama Aktiviti*</label>
            <div class="input-box">
                <input id="input-aktiviti" type='text' name='nama_aktiviti' placeholder="Nama Aktiviti" required><br>
            </div>

            <label for="input-tarikh">Tarikh Aktiviti*</label>
            <div class="input-box">
                <input id="input-tarikh" type='date' name='tarikh_aktiviti' min='<?= date("Y-m-d") ?>' required><br>
            </div>

            <label for="input-masa">Masa Mula*</label>
            <div class="input-box">
                <input id="input-masa" type='time' name='masa_mula' placeholder="Masa Mula" required><br>
            </div>

            <label for="input-masa">Masa Tamat*</label>
            <div class="input-box">
                <input id="input-masa" type='time' name='masa_tamat' placeholder="Masa Tamat" required><br>
            </div>

            <input class="btn" type='submit' value='Tambah'>

        </form>
    </div>
</main>