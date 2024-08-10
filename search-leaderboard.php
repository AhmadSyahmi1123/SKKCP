<?php
# Memanggil fail connection.php untuk sambungan ke pangkalan data
include ("connection.php");

# Memeriksa jika borang dihantar dan nama tidak kosong
if (isset($_POST['nama'])) {
    # Mendapatkan nama dari borang dan melarikan input untuk keselamatan
    $nama = mysqli_real_escape_string($condb, $_POST['nama']);

    # Arahan query untuk mendapatkan senarai ahli
    # Arahan SQL untuk mendapatkan maklumat ahli berdasarkan nama dan menyusun mengikut mata secara menurun
    $arahan_papar = "SELECT ahli.nama, ahli.mata, ahli.profile_pic, kelas.ting, kelas.nama_kelas
                     FROM ahli
                     JOIN kelas ON ahli.IDkelas = kelas.IDkelas
                     WHERE ahli.nama LIKE '%$nama%'
                     ORDER BY mata DESC";

    # Laksanakan arahan untuk mendapatkan data
    $laksana = mysqli_query($condb, $arahan_papar);
    $bil = 1;

    # Mengambil dan memaparkan data ahli dalam jadual
    while ($m = mysqli_fetch_array($laksana)) {
        # Papar imej medal bagi kedudukan 1st, 2nd dan 3rd
        $image = '';
        if ($bil == 1) {
            $image = '<img src="img/gold_medal.png" alt="Gold Medal" class="medal-icon">';
            $bil++;
        } elseif ($bil == 2) {
            $image = '<img src="img/silver_medal.png" alt="Silver Medal" class="medal-icon">';
            $bil++;
        } elseif ($bil == 3) {
            $image = '<img src="img/bronze_medal.png" alt="Bronze Medal" class="medal-icon">';
            $bil++;
        } else {
            $image = $bil++;
        }

        echo "<tr>
                <td align='center'>" . $image . "</td>
                <td><div class='profile_img_list_container'><img class='profile_img_list' src='uploads/" . $m['profile_pic'] . "'></div><div class='td-name'>" . $m['nama'] . "</div></td>
                <td>" . $m['ting'] . " " . $m['nama_kelas'] . "</td>
                <td>" . $m['mata'] . "</td>
                ";
        echo "</td></tr>";
    }
}