<?php
# Memulakan fungsi session
session_start();

# Memanggil fail connection.php
include ("connection.php");

# Mendapatkan masa semasa
$masa = date("H:i:s");

# Menyemak kewujudan data GET IDaktiviti dan sesi pengguna
if (!empty($_GET['IDaktiviti']) && !empty($_SESSION['nokp'])) {

    # Arahan untuk mendapatkan maklumat aktiviti dari pangkalan data berdasarkan IDaktiviti
    $command_masa = "SELECT * FROM aktiviti WHERE IDaktiviti = " . $_GET['IDaktiviti'];
    $laksana_masa = mysqli_query($condb, $command_masa);
    $get_aktiviti = mysqli_fetch_assoc($laksana_masa);

    # Mengubah masa mula dan masa tamat aktiviti kepada format timestamp
    $masa_mula = strtotime($get_aktiviti['masa_mula']);
    $masa_tamat = strtotime($get_aktiviti['masa_tamat']);

    # Mengubah masa semasa kepada format timestamp
    $masa_hadir = strtotime($masa);

    # Menyemak jika masa hadir berada dalam tempoh masa aktiviti
    if ($masa_hadir >= $masa_mula && $masa_hadir <= $masa_tamat) {

        # Mengira masa lewat dalam minit
        $masa_lewat = round(($masa_hadir - $masa_mula) / 60);

        # Menentukan mata berdasarkan masa lewat
        $points = 10;

        if ($masa_lewat <= 3) {
            $points = 5;
        } elseif ($masa_lewat <= 5) {
            $points = 3;
        } else {
            $points = 1;
        }
    }

    # Arahan untuk mengemaskini mata ahli berdasarkan keputusan di atas
    $kemaskini_mata = "UPDATE ahli SET mata = mata + $points WHERE nokp = '" . $_SESSION['nokp'] . "'";

    # Arahan untuk menyimpan data kehadiran dalam pangkalan data
    $sql = "INSERT INTO kehadiran (IDaktiviti, nokp, masa_hadir)
    VALUES ('" . $_GET['IDaktiviti'] . "', '" . $_SESSION['nokp'] . "', '$masa')";

    # Melaksanakan arahan simpan data kehadiran
    $simpan_data = mysqli_query($condb, $sql);

    # Melaksanakan arahan kemaskini mata murid
    $laksana_kemaskini_mata = mysqli_query($condb, $kemaskini_mata);

    # Menguji jika proses simpan data kehadiran berjaya
    # Laksana dan semak proses kemaskini mata
    if ($simpan_data) {
        # Kemaskini berjaya

        # Query kemaskini kedudukan ahli berdasarkan mata
        $rankUpdateQuery = "
            SET @rank := 0;
            UPDATE ahli
            JOIN (
                SELECT 
                    nokp, 
                    @rank := @rank + 1 AS rank 
                FROM ahli 
                ORDER BY mata DESC
            ) ranked ON ahli.nokp = ranked.nokp
            SET ahli.rank = ranked.rank;
        ";

        # Laksana dan semak proses kemaskini kedudukan
        if (mysqli_multi_query($condb, $rankUpdateQuery)) {
            $message = "Kemaskini Kehadiran dan Kedudukan Berjaya!";
            $notificationType = 'success';
            $notificationMessage = $message;
        } else {
            $message = "Ralat! Kemaskini Ranking Gagal!";
            $notificationType = 'error';
            $notificationMessage = $message;
        }
    } else {
        # Kemaskini gagal
        $message = "Ralat! Kemaskini Mata Gagal!";
        $notificationType = 'error';
        $notificationMessage = $message;
    }

    # Redirect dengan parameter notifikasi
    header("Location: profil.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
    exit();
} else {
    # Jika IDaktiviti atau sesi pengguna tidak wujud, paparkan amaran dan logout
    echo "<script>alert('Akses secara terus');
        window.location.href='logout.php'; </script>";
}
