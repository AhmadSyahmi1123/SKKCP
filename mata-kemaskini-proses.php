<?php
# Memulakan fungsi session
session_start();

# Memanggil fail kawalan-admin.php
include ("kawalan-admin.php");

# Menyemak jika data POST wujud
if (!empty($_POST["mata"])) {

    # Memanggil fail connection.php
    include ("connection.php");

    # Dapatkan IDaktiviti yang tersorok dari borang
    $IDaktiviti = $_POST['IDaktiviti'];

    # Arahan SQL (query) untuk tambah mata ahli
    $arahan = "UPDATE ahli
                SET mata = mata + '" . $_POST['mata'] . "'
                WHERE nokp = '" . $_GET['nokp'] . "'
                ";

    # Laksana dan semak proses kemaskini
    if (mysqli_query($condb, $arahan)) {
        # Kemaskini berjaya
        $message = "Kemaskini Mata Berjaya!";
        $notificationType = 'success';
        $notificationMessage = $message;
    } else {
        # Kemaskini gagal
        $message = "Ralat! Kemaskini Mata Gagal!!";
        $notificationType = 'error';
        $notificationMessage = $message;
    }

    // Redirect with notification parameters
    header("Location: kehadiran-laporan.php?notificationType=$notificationType&notificationMessage=$notificationMessage&IDaktiviti=$IDaktiviti");
    exit();
} else {
    # Jika data adalah nombor 0, refresh page
    die("<script>alert('Sila masukkan nombor selain 0');
    window.location.href='kehadiran-laporan.php';</script>");
}