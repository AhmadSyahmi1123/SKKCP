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
    nama_aktiviti = '" . $_POST['nama_aktiviti'] . "',
    tarikh_aktiviti = '" . $_POST['tarikh_aktiviti'] . "',
    masa_mula = '" . $_POST['masa_mula'] . "',
    masa_tamat = '" . $_POST['masa_tamat'] . "'
    where
    IDaktiviti = '" . $_GET['IDaktiviti'] . "'
    ";

    # Laksana & semak arahan SQL kemaskini data
    if (mysqli_query($condb, $arahan)) {
        # If the data stored successfully
        $_SESSION['notificationType'] = 'success';
        $_SESSION['notificationMessage'] = "Maklumat aktiviti berjaya dikemaskini!";
    } else {
        # If the data NOT stored successfully
        $_SESSION['notificationType'] = 'error';
        $_SESSION['notificationMessage'] = "Ralat: Gagal kemaskini maklumat aktiviti.";
    }

    # Redirect back to senarai-aktiviti.php
    header("Location: senarai-aktiviti.php");
    exit();
} else {
    # Jika data GET tidak wujud/kosong, kembali ke fail senarai-aktiviti
    $_SESSION['notificationType'] = 'error';
    $_SESSION['notificationMessage'] = "Sila lengkapkan maklumat.";
    header("Location: senarai-aktiviti.php");
    exit();
}
