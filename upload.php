<?php
#Memulakan fungsi session
session_start();

# Data validation : menyemak kewujudan data dari borang
if (isset($_POST)) {
    # Memanggil fail connection.php
    include ("connection.php");

    # Mengambil nama sementara fail
    $nama_fail_sementara = $_FILES["data_ahli"]["tmp_name"];

    # Mengambil nama fail
    $nama_fail = $_FILES["data_ahli"]["name"];

    # Mengambil jenis fail
    $jenis_fail = pathinfo($nama_fail, PATHINFO_EXTENSION);

    # Menguji jenis fail dan saiz fail
    if ($_FILES["data_ahli"]["size"] > 0 and $jenis_fail == 'txt') {
        # Membuka fail yang diambil
        $fail_data_ahli = fopen($nama_fail_sementara, 'r');

        # Mendapatkan data dari fail baris demi baris
        while (!feof($fail_data_ahli)) {
            # Mengambil data sebaris sahaja bagi setiap pusingan
            $ambil_baris_data = fgets($fail_data_ahli);
            # Memecahkan baris data mengikut tanda pipe
            $pecahkan_baris = explode("|", $ambil_baris_data);
            # Pecahan tersebut akan diumpukkan kepada 5
            list($nokp, $nama, $IDkelas, $katalaluan, $tahap) = $pecahkan_baris;

            $nama = strtoupper($nama);

            # Arahan SQL untuk menyimpan data
            $arahan_sql_simpan = "insert into ahli (nama, nokp, IDkelas, katalaluan, tahap, profile_pic) values ('$nama', '$nokp', '$IDkelas', '$katalaluan', '$tahap', DEFAULT)";
            # Laksana arahan simpan data ke dalam jadual ahli
            $laksana_arahan_simpan = mysqli_query($condb, $arahan_sql_simpan);

        }
        # Menutup fail .txt yang dibuka
        fclose($fail_data_ahli);
    }
}