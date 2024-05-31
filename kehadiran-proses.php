<?php
# Memanggil fail connection.php
include ("connection.php");

# Memadam data kehadiran lama supaya data kehadiran baru dapat dimasukkan
$sql_padam = mysqli_query($condb, "delete from kehadiran where IDaktiviti='" . $_GET['IDaktiviti'] . "'");

$masa = date("H:i:s");
foreach ($_POST['kehadiran'] as $nokp) {
    # Menyimpan semula data kehadiran baru
    $simpan_data = mysqli_query($condb, "insert into kehadiran
    (nokp, IDaktiviti, masa_hadir) values
    ('$nokp', '" . $_GET['IDaktiviti'] . "', '$masa') ");

    $kemaskini_mata = mysqli_query($condb, "update ahli
    set mata = mata + 100
    where nokp = '$nokp'
    ");
}

# Laksana dan semak proses kemaskini
if ($simpan_data) {
    # Kemaskini berjaya
    $message = "Kehadiran Berjaya Dikemaskini!";
    $notificationType = 'success';
    $notificationMessage = $message;
} else {
    # Kemaskini gagal
    $message = "Ralat! Kemaskini Gagal Dikemaskini!";
    $notificationType = 'error';
    $notificationMessage = $message;
}

// Redirect with notification parameters
header("Location: senarai-aktiviti.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
exit();