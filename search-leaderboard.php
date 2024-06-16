<?php
include ("connection.php");

if (isset($_POST['nama'])) {
    $nama = mysqli_real_escape_string($condb, $_POST['nama']);
    $arahan_papar = "SELECT ahli.nama, ahli.mata, ahli.profile_pic, kelas.ting, kelas.nama_kelas
                     FROM ahli
                     JOIN kelas ON ahli.IDkelas = kelas.IDkelas
                     WHERE ahli.nama LIKE '%$nama%'
                     ORDER BY mata DESC";

    $laksana = mysqli_query($condb, $arahan_papar);
    $bil = 0;

    while ($m = mysqli_fetch_array($laksana)) {
        echo "<tr>
                <td>" . ++$bil . "</td>
                <td><div class='profile_img_list_container'><img class='profile_img_list' src='uploads/" . $m['profile_pic'] . "'></div><div class='td-name'>" . $m['nama'] . "</div></td>
                <td>" . $m['ting'] . " " . $m['nama_kelas'] . "</td>
                <td>" . $m['mata'] . "</td>
              </tr>";
    }
}