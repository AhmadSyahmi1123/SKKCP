<?php
# Memulakan fungsi session
session_start();

# Memanggil fail kawalan-admin.php
include("kawalan-admin.php");

#  Menyemak kewujudan data GET nokp ahli
if(!empty($_GET)){
    # Memanggil fail connection.php
    include("connection.php");

    # Arahan SQL untuk memadam data ahli berdasarkan nokp yang dihantar
    $arahan = "delete from ahli where nokp = '".$_GET['nokp']."'";

    # Melaksanakan arahan SQL padam data ahli dan menguji proses padam data
    if(mysqli_query($condb, $arahan)){
        # Jika data berjaya dipadam
        echo "<script>alert('Padam Data Berjaya');
        window.location.href='senarai-ahli.php';</script>";
    }
    else{
        # Jika data gagal dipadam
        echo "<script>alert('Padam Data Gagal');
        window.location.href='senarai-ahli.php';</script>";
    }
}
else{
    # Jika data GET tidak wujud/kosong
    die("<script>alert('Ralat! Akses Secara Terus');
    window.location.href='senarai-ahli.php';</script>");
}