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
        $kemaskini_mata = mysqli_query($condb, "UPDATE ahli SET mata = mata + 100 WHERE nokp = '$nokp'");
    }
}

# Laksana dan semak proses kemaskini
if ($simpan_data) {
    # Kemaskini berjaya
    $message = "Kehadiran Berjaya Dikemaskini!";
    $notificationType = 'success';
    $notificationMessage = $message;
} else {
    # Kemaskini gagal
    $message = "Ralat! Kehadiran Gagal Dikemaskini!";
    $notificationType = 'error';
    $notificationMessage = $message;
}

// Redirect with notification parameters
header("Location: senarai-aktiviti.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
exit();
