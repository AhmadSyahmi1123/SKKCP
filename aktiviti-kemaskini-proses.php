<?php
# Memulakan sesi PHP untuk menyimpan maklumat pengguna
session_start();

# Memanggil fail kawalan-admin.php yang mungkin mengandungi fungsi kawalan akses
include ("kawalan-admin.php");

# Menyemak jika terdapat data POST yang dihantar
if (!empty($_POST)) {

    # Memanggil fail connection.php untuk sambungan ke pangkalan data
    include ("connection.php");

    # Arahan SQL untuk mengemaskini maklumat aktiviti berdasarkan IDaktiviti yang dihantar melalui GET
    $arahan = "update aktiviti set
    nama_aktiviti = '" . strtoupper($_POST['nama_aktiviti']) . "',
    tarikh_aktiviti = '" . $_POST['tarikh_aktiviti'] . "',
    masa_mula = '" . $_POST['masa_mula'] . "',
    masa_tamat = '" . $_POST['masa_tamat'] . "'
    where
    IDaktiviti = '" . $_GET['IDaktiviti'] . "'
    ";

    # Melaksanakan arahan SQL untuk kemaskini data aktiviti dan semak hasilnya
    if (mysqli_query($condb, $arahan)) {
        $message = "Pendaftaran Aktiviti Berjaya!";
        $notificationType = 'success';
        $notificationMessage = $message;
    } else {
        $message = "Pendaftaran Aktiviti Gagal!";
        $notificationType = 'error';
        $notificationMessage = $message;
    }

    # Redirect ke senarai-aktiviti.php dengan parameter notifikasi kejayaan atau kegagalan
    header("Location: senarai-aktiviti.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
    exit();
} else {
    # Jika tiada data POST, alihkan ke senarai-aktiviti.php dengan mesej notifikasi ralat
    $message = "Sila lengkapkan maklumat.";
    $notificationType = 'error';
    $notificationMessage = $message;

    # Redirect ke senarai-aktiviti.php dengan parameter notifikasi ralat
    header("Location: senarai-aktiviti.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
    exit();
}
