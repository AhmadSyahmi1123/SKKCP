<?php
# Memulakan fungsi session
session_start();

# Memanggil fail kawalan-admin.php
include("kawalan-admin.php");

# Menyemak jika data POST wujud
if (!empty($_POST)) {

    # Memanggil fail connection.php
    include("connection.php");

    # Arahan SQL (query) untuk kemaskini maklumat aktiviti
    $arahan = "update aktiviti set
    nama_aktiviti = '" . strtoupper($_POST['nama_aktiviti']) . "',
    tarikh_aktiviti = '" . $_POST['tarikh_aktiviti'] . "',
    masa_mula = '" . $_POST['masa_mula'] . "',
    masa_tamat = '" . $_POST['masa_tamat'] . "'
    where
    IDaktiviti = '" . $_GET['IDaktiviti'] . "'
    ";

    # Laksana & semak arahan SQL kemaskini data
    if (mysqli_query($condb, $arahan)) {
        $message = "Pendaftaran Aktiviti Berjaya!";
        $notificationType = 'success';
        $notificationMessage = $message;
    } else {
        $message = "Pendaftaran Aktiviti Gagal!";
        $notificationType = 'error';
        $notificationMessage = $message;
    }

    // Redirect with notification parameters
    header("Location: senarai-aktiviti.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
    exit();
} else {
    # Jika data GET tidak wujud/kosong, kembali ke fail senarai-aktiviti
    $message = "Sila lengkapkan maklumat.";
    $notificationType = 'error';
    $notificationMessage = $message;

    // Redirect with notification parameters
    header("Location: senarai-aktiviti.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
    exit();
}
