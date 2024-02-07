<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, kawalan-admin.php dan connection.php
include("header.php");
include("kawalan-admin.php");
include("connection.php");

# Menyemak jika data GET wujud. Jika tidak, buka fail senarai-aktiviti.php
if(empty($_GET)){
    die("<script>window.location.href='senarai-aktiviti.php';</script>");
}

# Mendapatkan maklumat aktiviti dari pangkalan data
$arahan_sql_pilihan = "select * from aktiviti where IDaktiviti='".$_GET['IDaktiviti']."' ";

# Laksana arahan mendapatkan maklumat
$laksana_arahan = mysqli_query($condb,$arahan_sql_pilihan);
$m = mysqli_fetch_array($laksana_arahan);
?>

<h3>Kemaskini Borang Baru</h3>

<form action="aktiviti-kemaskini-proses.php?IDaktiviti=<?= $m['IDaktiviti'] ?>" method="POST">

Nama Aktiviti
<input type='text' name='nama_aktiviti' value="<?= $m['nama_aktiviti'] ?>" required><br>

Tarikh Aktiviti
<input type='date' name='tarikh_aktiviti' min='<?= date("Y-m-d") ?>' value="<?= $m['tarikh_aktiviti'] ?>" required><br>

Masa Mula
<input type='text' name='masa_mula' <?= $m['masa_mula'] ?> required><br>

<input type='submit' value='Kemaskini'><br>
</form>