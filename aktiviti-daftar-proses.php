<?php
# Memulakan sesi PHP untuk menyimpan maklumat pengguna
session_start();

# Memanggil fail kawalan-admin.php yang mungkin mengandungi fungsi kawalan akses
include ("kawalan-admin.php");

# Menyemak jika terdapat data POST yang dihantar
if (!empty($_POST)) {
    # Memanggil fail connection.php untuk sambungan ke pangkalan data
    include ("connection.php");

    # Arahan SQL untuk menyimpan data aktiviti baru ke dalam pangkalan data
    $arahan_sql_simpan = "insert into aktiviti ( nama_aktiviti, tarikh_aktiviti, masa_mula, masa_tamat ) 
    values ('" . strtoupper($_POST['nama_aktiviti']) . "', '" . $_POST['tarikh_aktiviti'] . "', '" . $_POST['masa_mula'] . "', '" . $_POST['masa_tamat'] . "')";

    # Melaksanakan arahan SQL untuk menyimpan data aktiviti baru
    $laksana_arahan_simpan = mysqli_query($condb, $arahan_sql_simpan);

    # Menguji jika proses menyimpan data berjaya atau tidak
    if ($laksana_arahan_simpan) {
        $message = "Pendaftaran Aktiviti Berjaya!";
        $notificationType = 'success';
        $notificationMessage = $message;
    } else {
        $message = "Pendaftaran Aktiviti Gagal!";
        $notificationType = 'error';
        $notificationMessage = $message;
    }

    # Redirect ke senarai-aktiviti.php dengan parameter notifikasi
    header("Location: senarai-aktiviti.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
    exit();
}
