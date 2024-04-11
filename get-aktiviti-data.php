<?php
include("connection.php");

// Syarat tambahan yang akan dimasukkan dalam arahan(query) senarai aktiviti
$cari_aktiviti = "";
if (!empty($_POST["nama_aktiviti"])) {
    $tambahcari_aktivitian = "where nama_aktiviti like '%" . $_POST['nama_aktiviti'] . "%'";
}

// Araham query untuk mencari senarai aktiviti
$arahan_papar = "SELECT * FROM aktiviti $cari_aktiviti";

// Laksana arahan mencari senarai aktiviti
$laksana = mysqli_query($condb, $arahan_papar);

$aktiviti_data = array();

// Mengambil data yang ditemui
while ($m = mysqli_fetch_assoc($laksana)) {
    $aktiviti_data[] = array(
        'nama_aktiviti' => $m['nama_aktiviti'],
        'tarikh_aktiviti' => date('d/m/Y', strtotime($m['tarikh_aktiviti'])),
        'masa_mula' => date('H:i', strtotime($m['masa_mula'])),
        'masa_tamat' => date('H:i', strtotime($m['masa_tamat'])),
        'IDaktiviti' => $m['IDaktiviti']
    );
}

// Return the data in JSON format
echo json_encode($aktiviti_data);
