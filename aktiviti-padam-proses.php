<?php
# Memulakan fungsi session
session_start();

# Memanggil fail kawalan-admin.php
include("kawalan-admin.php");

# Menyemak jika data POST wujud
if(!empty($_GET)){

    # Memanggil fail connection.php
    include("connection.php");

    # Arahan SQL (query) untuk memadam aktiviti
    $arahan = "delete from aktiviti where IDaktiviti = '".$_GET['IDaktiviti']."'";

    # Laksana arahan padam aktiviti
    if(mysqli_query($condb, $arahan)){
        # Jika berjaya dipadam
        echo "<script>alert('Padam Data Berjaya!');
        window.location.href='senarai-aktiviti.php';</script>";
    }
    else{
        # Jika gagal dipadam
        echo "<script>alert('Padam Data Gagal!');
        window.location.href='senarai-aktiviti.php';</script>";
    }
}
else{
    # Jika data GET tidak wujud/kosong, kembali ke fail senarai-aktiviti
    die("<script>alert('Ralat! Akses Secara Terus');
    window.location.href='senarai-aktiviti.php';</script>");
}