<?php
# Memulakan fungsi session
session_start();

# Memanggil fail connection.php
include("connection.php");

$masa = date("H:i:s");

# Menyemakkan kewujudan data GET IDakiviti
if (!empty($_GET['IDaktiviti']) and !empty($_SESSION['nokp'])) {
    # Arahan simpan data kehadiran
    $sql = "insert into kehadiran (IDaktiviti, nokp, masa_hadir)
    values ('" . $_GET['IDaktiviti'] . "', '" . $_SESSION['nokp'] . "', '$masa') ";

    # Arahan kemaskini mata murid 
    $kemaskini_mata = "UPDATE ahli SET mata = mata + 10 WHERE nokp = '" . $_SESSION['nokp'] . "'";

    # Melaksanakan arahan simpan data kehadiran
    $simpan_data = mysqli_query($condb, $sql);

    # Laksana arahan kemaskini mata murid
    $laksana_kemaskini_mata = mysqli_query($condb, $kemaskini_mata);

    # Menguji proses simpan data kehadiran
    if ($simpan_data) {
        echo "<script>alert('Kehadiran Telah Disahkan!');
        window.location.href='profil.php'; </script>";
    }
} else {
    echo "<script>alert('Akses secara terus');
        window.location.href='logout.php'; </script>";
}
?>