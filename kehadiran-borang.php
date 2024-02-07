<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, connection.php dan kawalan-admin.php
include("header.php");
include("connection.php");
include("kawalan-admin.php");

# Mendapatkan maklumat aktiviti dari pangkalan data
$arahan_sql_aktiviti = "select * from aktiviti where IDaktiviti='".$_GET['IDaktiviti']."' ";
$laksana_aktiviti = mysqli_query($condb, $arahan_sql_aktiviti);
$n = mysqli_fetch_array($laksana_aktiviti);
?>

<h3>Pengesahan Kehadiran Ahli</h3>

Nama Aktiviti : <?= $n['nama_aktiviti'] ?> <br>
Tarikh | Masa : <?= $n['tarikh_aktiviti'] ?> | <?= $n['masa_mula'] ?> <br>
<br><br>

<form action="kehadiran-proses.php?IDaktiviti=<?= $_GET['IDaktiviti'] ?>" method="POST" >
<table border='1' id="saiz" width='100%' >
    <tr>
        <td>Bil</td>
        <td>Nama</td>
        <td>No Kad Pengenalan</td>
        <td>Kelas</td>
        <td>Kehadiran</td>
    </tr>

    <?php
    # Arahan untuk mendapatkan data kehadiran setiap ahli
    $arahan_sql_kehadiran = "SELECT ahli.nokp, ahli.nama, kelas.ting, kelas.nama_kelas, kehadiran.IDaktiviti
    FROM ahli
    LEFT JOIN kelas
    ON ahli.IDkelas = kelas.IDkelas
    LEFT JOIN kehadiran
    ON ahli.nokp = kehadiran.nokp
    AND kehadiran.IDaktiviti = '".$_GET['IDaktiviti']."'
    ORDER BY ahli.nama";

    # Laksana arahan untuk memproses data
    $laksana_kehadiran = mysqli_query($condb, $arahan_sql_kehadiran);
    $bil = 0;

    # Mengambil dan memaparkan semua data kehadiran yang ditemui
    while($m=mysqli_fetch_array($laksana_kehadiran)){ ?>
        <tr>
            <td><?= ++$bil; ?></td>
            <td><?= $m['nama'] ?></td>
            <td><?= $m['nokp'] ?></td>
            <td><?= $m['ting']." ".$m['nama_kelas'] ?></td>
            <td><?php

            if($m['IDaktiviti'] != null){
                $tanda = "checked";
            }
            else{
                $tanda = "";
            }
            ?>

            <input <?= $tanda ?> type="checkbox" name="kehadiran[]" value="<?= $m['nokp'] ?>" style="width:30px; height:30px;" >
            </td>
        </tr>
        <?php
    }
    ?>

    <tr>
        <td colspan="4"></td>
        <td><input type="submit" value="Simpan" ></td>
    </tr>
</table>
</form>