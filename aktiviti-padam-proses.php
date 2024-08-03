<?php
# Memulakan sesi PHP untuk menyimpan maklumat pengguna
session_start();

# Memanggil fail kawalan-admin.php yang mungkin mengandungi fungsi kawalan akses
include ("kawalan-admin.php");

# Menyemak jika terdapat data GET yang dihantar
if (!empty($_GET)) {

    # Memanggil fail connection.php untuk sambungan ke pangkalan data
    include ("connection.php");

    # Arahan SQL untuk memadam aktiviti berdasarkan IDaktiviti yang dihantar melalui GET
    $arahan = "delete from aktiviti where IDaktiviti = '" . $_GET['IDaktiviti'] . "'";

    # Melaksanakan arahan SQL untuk padam aktiviti dan semak hasilnya
    if (mysqli_query($condb, $arahan)) {
        $message = "Data Berjaya Dipadam!";
        $notificationType = 'success';
        $notificationMessage = $message;
    } else {
        # Jika gagal dipadam, set mesej ralat
        $message = "Ralat! Data Gagal Dipadam!";
        $notificationType = 'error';
        $notificationMessage = $message;
    }

    # Redirect ke senarai-aktiviti.php dengan parameter notifikasi kejayaan atau kegagalan
    header("Location: senarai-aktiviti.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
    exit();
} else {
    # Jika tiada data GET, alihkan ke senarai-aktiviti.php dengan mesej notifikasi ralat
    die("<script>alert('Ralat! Akses Secara Terus');
    window.location.href='senarai-aktiviti.php';</script>");
}
