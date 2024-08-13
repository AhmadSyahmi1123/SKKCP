<?php
# Memulakan fungsi session
session_start();

# Menyambung ke pangkalan data
include ("connection.php");

# Mendapatkan masa semasa
$masa = date("H:i:s");

# Mendapatkan IDaktiviti dari data POST
$IDaktiviti = $_POST["IDaktiviti"];

# Menyemak kewujudan data POST
if (!empty($_POST["nokp"])) {
    # Mendapatkan No Kad Pengenalan (nokp) dari data POST
    $nokp = mysqli_real_escape_string($condb, $_POST['nokp']);

    # Menyemak jika nokp yang dimasukkan telah wujud dalam pangkalan data ahli
    $arahan_sql_semak = "SELECT * FROM ahli WHERE nokp = '$nokp'";
    $laksana_arahan_semak = mysqli_query($condb, $arahan_sql_semak);

    if (mysqli_num_rows($laksana_arahan_semak) != 1) {
        # Jika nokp yang dimasukkan tidak wujud dalam pangkalan data ahli
        $notificationType = 'error';
        $notificationMessage = "No. Kad Pengenalan yang dimasukkan tiada dalam sistem";
    } else {
        # Menyemak jika nokp yang dimasukkan telah direkodkan dalam pangkalan data kehadiran
        $arahan_semak = "SELECT * FROM kehadiran WHERE nokp='$nokp' AND IDaktiviti='$IDaktiviti' LIMIT 1";
        $laksana_arahan = mysqli_query($condb, $arahan_semak);

        if (mysqli_num_rows($laksana_arahan) == 1) {
            # Jika nokp telah direkodkan dalam pangkalan data kehadiran
            $notificationType = 'error';
            $notificationMessage = "Anda telah mengesahkan kehadiran sebelum ini";
        } else {
            # Mendapatkan maklumat aktiviti dari pangkalan data
            $command_masa = "SELECT * FROM aktiviti WHERE IDaktiviti = $IDaktiviti";
            $laksana_masa = mysqli_query($condb, $command_masa);
            $get_aktiviti = mysqli_fetch_assoc($laksana_masa);

            $masa_mula = strtotime($get_aktiviti['masa_mula']);
            $masa_tamat = strtotime($get_aktiviti['masa_tamat']);
            $masa_hadir = strtotime($masa);

            # Memberi mata berdasarkan masa kehadiran
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
            $simpan_data = mysqli_query($condb, "INSERT INTO kehadiran (IDaktiviti, nokp, masa_hadir) VALUES ('$IDaktiviti', '$nokp', '$masa')");

            # Laksana dan semak proses kemaskini mata
            if ($simpan_data) {
                # Kemaskini berjaya

                # Kemaskini mata ahli dalam pangkalan data
                $kemaskini_mata = "UPDATE ahli SET mata = mata + $points WHERE nokp = '$nokp'";
                mysqli_query($condb, $kemaskini_mata);

                # Query kemaskini kedudukan ahli berdasarkan mata
                $rankUpdateQuery = "
            SET @rank := 0;
            UPDATE carta
            JOIN (
                SELECT 
                    nokp, 
                    @rank := @rank + 1 AS rank 
                FROM ahli 
                ORDER BY mata DESC
            ) ranked ON carta.nokp = ranked.nokp
            SET carta.rank = ranked.rank;
        ";

                # Laksana dan semak proses kemaskini kedudukan
                if (mysqli_multi_query($condb, $rankUpdateQuery)) {
                    $message = "Kemaskini Mata dan Kedudukan Berjaya!";
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
        }
    }
} else {
    # Menyemak jika borang telah dihantar tanpa mengisi nokp
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $notificationType = 'error';
        $notificationMessage = "Sila Isi No. Kad Pengenalan!";
    }
}

# Mengalih semula dengan parameter notifikasi
header("Location: kehadiran-rekod.php?notificationType=$notificationType&notificationMessage=$notificationMessage&IDaktiviti=$IDaktiviti");
exit();