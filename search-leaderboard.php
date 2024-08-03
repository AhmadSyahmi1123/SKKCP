<?php
# Memanggil fail connection.php untuk sambungan ke pangkalan data
include ("connection.php");

# Memeriksa jika borang dihantar dan nama tidak kosong
if (isset($_POST['nama'])) {
    # Mendapatkan nama dari borang dan melarikan input untuk keselamatan
    $nama = mysqli_real_escape_string($condb, $_POST['nama']);

    # Arahan SQL untuk mendapatkan maklumat ahli berdasarkan nama dan menyusun mengikut mata secara menurun
    $arahan_papar = "SELECT ahli.nama, ahli.mata, ahli.profile_pic, kelas.ting, kelas.nama_kelas
                     FROM ahli
                     JOIN kelas ON ahli.IDkelas = kelas.IDkelas
                     WHERE ahli.nama LIKE '%$nama%'
                     ORDER BY mata DESC";

    # Melaksanakan arahan SQL
    $laksana = mysqli_query($condb, $arahan_papar);
    $bil = 0;

    # Mengambil data dari hasil query dan memaparkannya dalam jadual
    while ($m = mysqli_fetch_array($laksana)) {
        # Memaparkan nombor urutan, gambar profil, nama, kelas dan mata ahli
        echo "<tr>
                <td>" . ++$bil . "</td>
                <td><div class='profile_img_list_container'><img class='profile_img_list' src='uploads/" . $m['profile_pic'] . "'></div><div class='td-name'>" . $m['nama'] . "</div></td>
                <td>" . $m['ting'] . " " . $m['nama_kelas'] . "</td>
                <td>" . $m['mata'] . "</td>
              </tr>";
    }
}