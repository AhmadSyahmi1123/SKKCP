<?php
# Memulakan fungsi session
session_start();

# Memanggil fail kawalan-admin.php
include ("kawalan-admin.php");

# Menyemak jika data POST wujud
if (!empty($_GET)) {

    # Memanggil fail connection.php
    include ("connection.php");

    # Arahan SQL (query) untuk memadam aktiviti
    $arahan = "delete from aktiviti where IDaktiviti = '" . $_GET['IDaktiviti'] . "'";

    # Laksana arahan padam aktiviti
    if (mysqli_query($condb, $arahan)) {
        $message = "Data Berjaya Dipadam!";
        $notificationType = 'success';
        $notificationMessage = $message;
    } else {
        # Jika gagal dipadam
        $message = "Ralat! Data Gagal Dipadam!";
        $notificationType = 'error';
        $notificationMessage = $message;
    }

    header("Location: senarai-aktiviti.php?notificationType=$notificationType&notificationMessage=$notificationMessage&IDaktiviti=$IDaktiviti");
    exit();
} else {
    # Jika data GET tidak wujud/kosong, kembali ke fail senarai-aktiviti
    die("<script>alert('Ralat! Akses Secara Terus');
    window.location.href='senarai-aktiviti.php';</script>");
}