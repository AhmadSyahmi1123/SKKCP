<?php
# Memulakan fungsi session
session_start();

# Memanggil fail kawalan-admin.php
include ("kawalan-admin.php");

# Semak kewujudan data POST
if (!empty($_POST)) {
    # Memanggil fail connection.php
    include ("connection.php");

    # Pengesahan data nokp ahli
    if (strlen($_POST["nokp"]) != 12 or !is_numeric($_POST["nokp"])) {
        die("<script>alert('Ralat No Kad Pengenalan');
        window.history.back();</script>");
    }

    # Arahan SQL (query) untuk kemaskini maklumat ahli
    $arahan = "update ahli set
    nama = '" . strtoupper($_POST['nama']) . "',
    nokp = '" . $_POST['nokp'] . "',
    katalaluan = '" . $_POST['katalaluan'] . "',
    IDkelas = '" . $_POST['IDkelas'] . "',
    tahap = '" . $_POST['tahap'] . "'
    where
    nokp = '" . $_GET['nokp_lama'] . "'
    ";

    # Laksana dan semak proses kemaskini
    if (mysqli_query($condb, $arahan)) {
        # Kemaskini berjaya
        # Kemaskini berjaya
        $message = "Maklumat Ahli Berjaya Dikemaskini!";
        $notificationType = 'success';
        $notificationMessage = $message;
    } else {
        # Kemaskini gagal
        $message = "Ralat! Maklumat Ahli Gagal Dikemaskini!";
        $notificationType = 'error';
        $notificationMessage = $message;
    }

    // Redirect with notification parameters
    header("Location: senarai-ahli.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
    exit();
} else {
    # Jika data GET tidak wujud, kembali ke fail senarai-ahli.php
    die("<script>alert('Sila lengkapkan data');
    window.location.href='senarai-ahli.php';</script>");
}