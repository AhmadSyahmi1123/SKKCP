<?php
# Memanggil fail connection.php
include("connection.php");

# Memadam data kehadiran lama supaya data kehadiran baru dapat dimasukkan
$sql_padam = mysqli_query($condb, "delete from kehadiran where IDaktiviti='".$_GET['IDaktiviti']."'");

$masa = date("H:i:s");
foreach($_POST['kehadiran'] as $nokp){
    # Menyimpan semula data kehadiran baru
    $simpan_data = mysqli_query($condb, "insert into kehadiran
    (nokp, IDaktiviti, masa_hadir) values
    ('$nokp', '".$_GET['IDaktiviti']."', '$masa') ");
}

echo "<script>alert('Kemaskini Kehadiran Selesai');
window.location.href='kehadiran-borang.php?IDaktiviti=".$_GET['IDaktiviti']."'; </script>"
?>