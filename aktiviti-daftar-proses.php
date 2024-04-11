<?php
# Memulakan fungsi session
session_start();

# Menyemak jika data POST wujud
if (!empty($_POST)) {
    # Memanggil fail connection.php
    include("connection.php");

    # Arahan SQL (query) untuk menyimpan data aktiviti baru
    $arahan_sql_simpan = "insert into aktiviti ( nama_aktiviti, tarikh_aktiviti, masa_mula, masa_tamat ) 
    values ('" . strtoupper($_POST['nama_aktiviti']) . "', '" . $_POST['tarikh_aktiviti'] . "', '" . $_POST['masa_mula'] . "', '" . $_POST['masa_tamat'] . "')";

    # Laksana arahan SQL menyimpan data aktiviti baru
    $laksana_arahan_simpan = mysqli_query($condb, $arahan_sql_simpan);
}
