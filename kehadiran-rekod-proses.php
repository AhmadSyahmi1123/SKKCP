<?php
# Memulakan fungsi session
session_start();

include("connection.php");

$masa = date("H:i:s");

$IDaktiviti = $_POST["IDaktiviti"];
# Menyemak kewujudan data POST
if (!empty($_POST["nokp"])) {
    # Menyemak jika nokp yang dimasukkan telah wujud dalam pangkalan data
    $arahan_sql_semak = "select * from ahli where nokp = '" . $_POST['nokp'] . "' ";
    # Laksana arahan semak
    $laksana_arahan_semak = mysqli_query($condb, $arahan_sql_semak);
    if (mysqli_num_rows($laksana_arahan_semak) != 1) {
        # Jika nokp yang dimasukkan telah wujud
        $message = "No. Kad Pengenalan yang dimasukkan tiada dalam sistem";
        $notificationType = 'error';
        $notificationMessage = $message;
    } else {
        # Menyemak jika nokp yang dimasukkan telah direkodkan dalam pangkalan data kehadiran
        $arahan_semak = "select * from kehadiran where nokp='" . $_POST['nokp'] . "' and IDaktiviti='" . $IDaktiviti . "' limit 1";
        $laksana_arahan = mysqli_query($condb, $arahan_semak);

        if (mysqli_num_rows($laksana_arahan) == 1) {
            $message = "Anda telah mengesahkan kehadiran sebelum ini";
            $notificationType = 'error';
            $notificationMessage = $message;
        } else {
            # Arahan beri mata kepada pengguna berdasarkan masa mereka hadir 
            $command_masa = "SELECT * FROM aktiviti WHERE IDaktiviti = " . $IDaktiviti;
            $laksana_masa = mysqli_query($condb, $command_masa);
            $get_aktiviti = mysqli_fetch_assoc($laksana_masa);

            $masa_mula = strtotime($get_aktiviti['masa_mula']);
            $masa_tamat = strtotime($get_aktiviti['masa_tamat']);

            $masa_hadir = strtotime($masa);

            $points = 10;

            if ($masa_hadir >= $masa_mula && $masa_hadir <= $masa_tamat) {

                $masa_lewat = round(($masa_hadir - $masa_mula) / 60);

                if ($masa_lewat <= 3) {
                    $points = 5;
                } elseif ($masa_lewat <= 5) {
                    $points = 3;
                } else {
                    $points = 1;
                }
            }

            # Menyimpan data kehadiran
            $simpan_data = mysqli_query($condb, "insert into kehadiran (IDaktiviti, nokp, masa_hadir) values ('" . $_GET['IDaktiviti'] . "', '" . $_POST['nokp'] . "', '$masa')");

            # Menyemak jika proses penyimpanan data berjaya
            if ($simpan_data) {
                # Arahan kemaskini mata murid 
                $kemaskini_mata = "UPDATE ahli SET mata = mata + $points WHERE nokp = '" . $_POST['nokp'] . "'";
                # Laksana arahan kemaskini mata murid
                $laksana_kemaskini_mata = mysqli_query($condb, $kemaskini_mata);

                $message = "Kehadiran berjaya direkod!";
                $notificationType = 'success';
                $notificationMessage = $message;
            } else {
                $message = "Kehadiran Gagal Direkod!";
                $notificationType = 'error';
                $notificationMessage = $message;
            }
        }
    }
} else {
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $message = "Sila Isi No. Kad Pengenalan!";
        $notificationType = 'error';
        $notificationMessage = $message;
    }
}

// Redirect with notification parameters
header("Location: kehadiran-rekod.php?notificationType=$notificationType&notificationMessage=$notificationMessage&IDaktiviti=$IDaktiviti");
exit();