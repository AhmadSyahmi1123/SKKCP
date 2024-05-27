<?php
# Memulakan fungsi session
session_start();

# Memanggil fail connection.php
include ("connection.php");

$masa = date("H:i:s");

# Menyemakkan kewujudan data GET IDakiviti
if (!empty($_GET['IDaktiviti']) and !empty($_SESSION['nokp'])) {

    # Arahan beri mata kepada pengguna berdasarkan masa mereka hadir 
    $command_masa = "SELECT * FROM aktiviti WHERE IDaktiviti = " . $_GET['IDaktiviti'];
    $laksana_masa = mysqli_query($condb, $command_masa);
    $get_aktiviti = mysqli_fetch_assoc($laksana_masa);

    $masa_mula = strtotime($get_aktiviti['masa_mula']);
    $masa_tamat = strtotime($get_aktiviti['masa_tamat']);

    $masa_hadir = strtotime($masa); // student's arrival time 

    if ($masa_hadir >= $masa_mula && $masa_hadir <= $masa_tamat) {

        $masa_lewat = round(($masa_hadir - $masa_mula) / 60);

        $points = 10;

        if ($masa_lewat <= 3) {
            $points = 5;
        } elseif ($masa_lewat <= 5) {
            $points = 3;
        } else {
            $points = 1;
        }
    }

    # Arahan kemaskini mata murid 
    $kemaskini_mata = "UPDATE ahli SET mata = mata + $points WHERE nokp = '" . $_SESSION['nokp'] . "'";

    # Arahan simpan data kehadiran
    $sql = "insert into kehadiran (IDaktiviti, nokp, masa_hadir)
    values ('" . $_GET['IDaktiviti'] . "', '" . $_SESSION['nokp'] . "', '$masa') ";

    # Melaksanakan arahan simpan data kehadiran
    $simpan_data = mysqli_query($condb, $sql);

    # Laksana arahan kemaskini mata murid
    $laksana_kemaskini_mata = mysqli_query($condb, $kemaskini_mata);

    # Menguji proses simpan data kehadiran
    if ($simpan_data) {
        $message = "Kehadiran Berjaya Disahkan!";
        $notificationType = 'success';
        $notificationMessage = $message;
    } else {
        $message = "Ralat Kehadiran Gagal Disahkan!";
        $notificationType = 'error';
        $notificationMessage = $message;
    }

    // Redirect with notification parameters
    header("Location: profil.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
    exit();
} else {
    echo "<script>alert('Akses secara terus');
        window.location.href='logout.php'; </script>";
}