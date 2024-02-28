<?php
# Memulakan fungsi session
session_start();

# Memanggil fail kawalan-admin.php
include("kawalan-admin.php");

# Menyemak jika data POST wujud
if(!empty($_POST)){

    # Memanggil fail connection.php
    include("connection.php");

    # Arahan SQL (query) untuk tambah mata ahli
    $arahan = "UPDATE ahli
                SET mata = mata + '".$_POST['mata']."'
                WHERE nokp = '".$_GET['nokp']."'
                ";

    # Laksana dan semak proses kemaskini
    if(mysqli_query($condb, $arahan)){
        # Kemaskini berjaya
        echo "<script>alert('Kemaskini Berjaya!');
        window.location.href='senarai-aktiviti.php';</script>";
    }
    else{
        # Kemaskini gagal
        echo "<script>alert('Kemaskini Gagal');
        window.history.back();</script>";
    }
}
else{
    # Jika data GET tidak wujud/kosong, kembali ke fail senarai-aktiviti
    die("<script>alert('Sila lengkapkan maklumat');
    window.location.href='senarai-aktiviti.php';</script>");
}