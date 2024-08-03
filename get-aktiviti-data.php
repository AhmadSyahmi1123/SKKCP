<?php
# Memanggil fail sambungan ke pangkalan data
include ("connection.php");

// Memeriksa jika data POST wujud dan mengandungi carian aktiviti
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['aktiviti_carian'])) {
    $aktiviti_carian = $_POST['aktiviti_carian'];
    # Menyediakan syarat tambahan dalam arahan SQL untuk carian aktiviti
    $cari_aktiviti = "WHERE nama_aktiviti LIKE '%" . mysqli_real_escape_string($condb, $aktiviti_carian) . "%'";
} else {
    $cari_aktiviti = "";
}

// Arahan SQL untuk mendapatkan senarai aktiviti berdasarkan syarat carian
$arahan_papar = "SELECT * FROM aktiviti $cari_aktiviti";

// Melaksanakan arahan SQL untuk mendapatkan senarai aktiviti
$laksana = mysqli_query($condb, $arahan_papar);
$aktiviti_data = array();

// Mengambil data yang ditemui dan menyusunnya dalam array
while ($m = mysqli_fetch_assoc($laksana)) {
    $aktiviti_data[] = array(
        'nama_aktiviti' => $m['nama_aktiviti'],
        'tarikh_aktiviti' => date('d/m/Y', strtotime($m['tarikh_aktiviti'])),
        'masa_mula' => date('H:i', strtotime($m['masa_mula'])),
        'masa_tamat' => date('H:i', strtotime($m['masa_tamat'])),
        'IDaktiviti' => $m['IDaktiviti']
    );
}

// Memulangkan data dalam format JSON
echo json_encode($aktiviti_data);
?>