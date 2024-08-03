<?php
# Memulakan fungsi session untuk menyimpan maklumat pengguna
session_start();

# Memanggil fail kawalan-admin.php yang mungkin mengandungi fungsi kawalan akses
include ("kawalan-admin.php");

# Semak jika terdapat data POST yang dihantar
if (!empty($_POST)) {
    # Memanggil fail connection.php untuk sambungan ke pangkalan data
    include ("connection.php");

    # Pengesahan untuk No Kad Pengenalan (nokp) - mesti mempunyai 12 digit dan merupakan nombor
    if (strlen($_POST["nokp"]) != 12 or !is_numeric($_POST["nokp"])) {
        die("<script>alert('Ralat No Kad Pengenalan');
        window.history.back();</script>");
    }

    # Arahan SQL untuk mengemaskini maklumat ahli dalam pangkalan data
    $arahan = "update ahli set
    nama = '" . strtoupper($_POST['nama']) . "',
    nokp = '" . $_POST['nokp'] . "',
    katalaluan = '" . $_POST['katalaluan'] . "',
    IDkelas = '" . $_POST['IDkelas'] . "',
    tahap = '" . $_POST['tahap'] . "'
    where
    nokp = '" . $_GET['nokp_lama'] . "'
    ";

    # Laksana arahan SQL dan semak jika kemaskini berjaya
    if (mysqli_query($condb, $arahan)) {
        # Jika berjaya, sediakan mesej kejayaan
        $message = "Maklumat Ahli Berjaya Dikemaskini!";
        $notificationType = 'success';
        $notificationMessage = $message;
    } else {
        # Jika gagal, sediakan mesej ralat
        $message = "Ralat! Maklumat Ahli Gagal Dikemaskini!";
        $notificationType = 'error';
        $notificationMessage = $message;
    }

    # Redirect ke senarai-ahli.php dengan parameter notifikasi
    header("Location: senarai-ahli.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
    exit();
} else {
    # Jika tiada data POST, tunjukkan amaran dan kembali ke senarai-ahli.php
    die("<script>alert('Sila lengkapkan data');
    window.location.href='senarai-ahli.php';</script>");
}
