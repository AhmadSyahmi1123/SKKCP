<?php
include ("connection.php");

if (isset($_POST['nama'])) {
    $IDaktiviti = $_POST['IDaktiviti'];
    $nama = mysqli_real_escape_string($condb, $_POST['nama']);
    $arahan_papar = "SELECT *, ahli.nokp, ahli.nama, kelas.ting, kelas.nama_kelas, kehadiran.IDaktiviti 
                    FROM ahli
                    LEFT JOIN kelas ON ahli.IDkelas = kelas.IDkelas
                    LEFT JOIN kehadiran ON ahli.nokp = kehadiran.nokp AND kehadiran.IDaktiviti = '$IDaktiviti'
                    WHERE 1=1 and ahli.nama LIKE '%$nama%'
                    ORDER BY ahli.nama ASC";

    $laksana = mysqli_query($condb, $arahan_papar);
    $bil = 0;

    while ($m = mysqli_fetch_array($laksana)) { ?>
        <tr>
            <td>
                <?= ++$bil; ?>
            </td>
            <td>
                <?= $m['nama'] ?>
            </td>
            <td>
                <?= $m['nokp'] ?>
            </td>
            <td>
                <?= $m['ting'] . " " . $m['nama_kelas'] ?>
            </td>
            <td>
                <?php

                if ($m['IDaktiviti'] != null) {
                    $tanda = "checked";
                } else {
                    $tanda = "";
                }
                ?>

                <input <?= $tanda ?> type="checkbox" name="kehadiran[]" value="<?= $m['nokp'] ?>"
                    style="width:30px; height:30px;">
            </td>
        </tr>
        <?php
    }
}