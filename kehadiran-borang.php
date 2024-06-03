<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, connection.php dan kawalan-admin.php
include ("header.php");
include ("connection.php");
include ("kawalan-admin.php");

# Mendapatkan maklumat aktiviti dari pangkalan data
$arahan_sql_aktiviti = "select * from aktiviti where IDaktiviti='" . $_GET['IDaktiviti'] . "' ";
$laksana_aktiviti = mysqli_query($condb, $arahan_sql_aktiviti);
$n = mysqli_fetch_array($laksana_aktiviti);
?>

<div class="page-header">Pengesahan Kehadiran Ahli</div>
<main>
    <div class="kehadiran-details">
        Nama Aktiviti :
        <?= $n['nama_aktiviti'] ?> <br>
        Tarikh | Masa :
        <?= $n['tarikh_aktiviti'] ?> |
        <?= date('H:i', strtotime($n['masa_mula'])) ?> <br>
    </div>

    <div class="borang-container">
        <div class="searchNupload-container">
            <div class="input-carian-container">
                <form action='' method="POST">
                    <div class="input-carian">
                        <input type='text' name='nama' placeholder='Carian Nama Ahli'>
                    </div>

                    <button class="searchBtn" type='submit' value='Cari' data-tooltip="Cari">
                        <i class='bx bx-search'></i>
                    </button>
                </form>
            </div>
        </div>

        <form action="kehadiran-proses.php?IDaktiviti=<?= $_GET['IDaktiviti'] ?>" method="POST">
            <div class="table-container">
                <div class="scrollable-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Bil</th>
                                <th>Nama</th>
                                <th>No Kad Pengenalan</th>
                                <th>Kelas</th>
                                <th>Kehadiran</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            # Syarat tambahan yang akan dimasukkan dalam arahan(query) senarai ahli
                            $cari_ahli = "";
                            if (!empty($_POST["nama"])) {
                                $cari_ahli = " and ahli.nama like '%" . $_POST['nama'] . "%'";
                            }

                            # Arahan untuk mendapatkan data kehadiran setiap ahli
                            $arahan_sql_kehadiran = "SELECT *, ahli.nokp, ahli.nama, kelas.ting, kelas.nama_kelas, kehadiran.IDaktiviti 
                                            FROM ahli
                                            LEFT JOIN kelas ON ahli.IDkelas = kelas.IDkelas
                                            LEFT JOIN kehadiran ON ahli.nokp = kehadiran.nokp AND kehadiran.IDaktiviti = '" . $_GET['IDaktiviti'] . "'
                                            WHERE 1=1 $cari_ahli
                                            ORDER BY ahli.nama";

                            # Laksana arahan untuk memproses data
                            $laksana_kehadiran = mysqli_query($condb, $arahan_sql_kehadiran);
                            $bil = 0;

                            # Mengambil dan memaparkan semua data kehadiran yang ditemui
                            while ($m = mysqli_fetch_array($laksana_kehadiran)) { ?>
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
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
            <div class="save-container">
                <button class="saveBtn" type="submit">Simpan</button>
            </div>
        </form>
    </div>

</main>