<?php
# Memanggil fail connection.php
include ("connection.php");

$IDaktiviti = $_GET['IDaktiviti'];

# Dapatkan senarai nokp yang sudah hadir sebelum ini
$existing_nokp = [];
$result_existing = mysqli_query($condb, "SELECT nokp FROM kehadiran WHERE IDaktiviti='$IDaktiviti'");
while ($row = mysqli_fetch_assoc($result_existing)) {
    $existing_nokp[] = $row['nokp'];
}

# Memadam data kehadiran lama supaya data kehadiran baru dapat dimasukkan
$sql_padam = mysqli_query($condb, "DELETE FROM kehadiran WHERE IDaktiviti='$IDaktiviti'");

$masa = date("H:i:s");
foreach ($_POST['kehadiran'] as $nokp) {
    # Menyimpan semula data kehadiran baru
    $simpan_data = mysqli_query($condb, "INSERT INTO kehadiran (nokp, IDaktiviti, masa_hadir) VALUES ('$nokp', '$IDaktiviti', '$masa')");

    # Kemaskini mata hanya jika pengguna tidak mempunyai rekod kehadiran sebelumnya
    if (!in_array($nokp, $existing_nokp)) {
        $kemaskini_mata = mysqli_query($condb, "UPDATE ahli SET mata = mata + 10 WHERE nokp = '$nokp'");
    }
}

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

// Redirect with notification parameters
header("Location: senarai-aktiviti.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
exit();
