<?php
# Memulakan fungsi session
session_start();

# Menyemak jika data POST wujud
if(!empty($_POST)){
    # Memanggil fail connection.php
    include("connection.php");

    # Arahan SQL (query) untuk menyimpan data aktiviti baru
    $arahan_sql_simpan = "insert into aktiviti ( nama_aktiviti, tarikh_aktiviti, masa_mula ) 
    values ('".strtoupper($_POST['nama_aktiviti'])."', '".$_POST['tarikh_aktiviti']."', '".$_POST['masa_mula']."')";

    # Laksana arahan SQL menyimpan data aktiviti baru
    $laksana_arahan_simpan = mysqli_query($condb, $arahan_sql_simpan);

    # Menguji jika proses menyimpan data berjaya atau tidak
    if($laksana_arahan_simpan){
        # Jika berjaya, papar popup dan buka fail senarai-aktiviti.php
        echo "<script>alert('Pendaftaran Aktiviti Berjaya.');
        window.location.href='senarai-aktiviti.php'; </script>";
    }
    else{
        # Jika gagal, papar popup dan buka fail aktiviti-daftar-borang.php
        echo "<script>alert('Pendaftaran Aktiviti Gagal.');
        window.location.href='aktiviti-daftar-borang.php'; </script>";
    }
}
else{
    # Jika pengguna tidak mengisi data, papar popup dan buka fail aktiviti-daftar-borang.php
    echo "<script>alert('Sila lengkapkan maklumat!');
    window.location.href='aktiviti-daftar-borang.php'; </script>";
}