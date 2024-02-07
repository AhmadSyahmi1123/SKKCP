<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php dan kawalan-admin.php
include("header.php");
include("kawalan-admin.php");
?>

<h3> Daftar Aktiviti Baru </h3>
<!-- Borang untuk menerima data aktiviti baharu daripada pengguna -->
<form action='aktiviti-daftar-proses.php' method='POST'>

Nama Aktiviti
<input type='text' name='nama_aktiviti' required><br>

Tarikh Aktiviti
<input type='date' name='tarikh_aktiviti' min='<?= date("Y-m-d") ?>' required><br>

Masa Mula
<input type='text' name='masa_mula' required><br>

<input type='submit' value='Daftar'><br>

</form>