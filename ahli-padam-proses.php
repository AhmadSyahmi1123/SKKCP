<?php
# Memulakan sesi PHP untuk menyimpan maklumat pengguna
session_start();

# Memanggil fail kawalan-admin.php yang mungkin mengandungi kawalan akses atau fungsi lain
include ("kawalan-admin.php");

# Menyemak jika terdapat data GET yang dihantar, khususnya 'nokp'
if (!empty($_GET)) {
    # Memanggil fail connection.php untuk sambungan ke pangkalan data
    include ("connection.php");

    # Arahan SQL untuk memadam data ahli berdasarkan nokp yang dihantar
    $arahan = "delete from ahli where nokp = '" . $_GET['nokp'] . "'";

    # Melaksanakan arahan SQL untuk memadam data dan semak jika operasi berjaya
    if (mysqli_query($condb, $arahan)) {
        # Jika berjaya, sediakan mesej kejayaan
        $message = "Data Berjaya Dipadam!";
        $notificationType = 'success';
        $notificationMessage = $message;
    } else {
        # Jika gagal, sediakan mesej ralat
        $message = "Ralat! Data Gagal Dipadam!";
        $notificationType = 'error';
        $notificationMessage = $message;
    }

    # Redirect ke senarai-ahli.php dengan parameter notifikasi
    header("Location: senarai-ahli.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
    exit();
} else {
    # Jika tiada data GET atau data GET kosong, tunjukkan amaran dan kembali ke senarai-ahli.php
    die("<script>alert('Ralat! Akses Secara Terus');
    window.location.href='senarai-ahli.php';</script>");
}
