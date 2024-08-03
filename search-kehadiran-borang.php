<?php
# Memanggil fail connection.php untuk sambungan ke pangkalan data
include ("connection.php");

# Memeriksa jika borang dihantar dan nama tidak kosong
if (isset($_POST['nama'])) {
    # Mendapatkan IDaktiviti dan nama dari borang
    $IDaktiviti = $_POST['IDaktiviti'];
    $nama = mysqli_real_escape_string($condb, $_POST['nama']);

    # Arahan SQL untuk mendapatkan maklumat ahli bersama kehadiran mereka berdasarkan nama dan IDaktiviti
    $arahan_papar = "SELECT *, ahli.nokp, ahli.nama, kelas.ting, kelas.nama_kelas, kehadiran.IDaktiviti 
                    FROM ahli
                    LEFT JOIN kelas ON ahli.IDkelas = kelas.IDkelas
                    LEFT JOIN kehadiran ON ahli.nokp = kehadiran.nokp AND kehadiran.IDaktiviti = '$IDaktiviti'
                    WHERE 1=1 AND ahli.nama LIKE '%$nama%'
                    ORDER BY ahli.nama ASC";

    # Melaksanakan arahan SQL
    $laksana = mysqli_query($condb, $arahan_papar);
    $bil = 0;

    # Mengambil data dari hasil query dan memaparkannya dalam jadual
    while ($m = mysqli_fetch_array($laksana)) { ?>
        <tr>
            <!-- Menampilkan nombor urutan ahli -->
            <td>
                <?= ++$bil; ?>
            </td>
            <!-- Menampilkan nama ahli -->
            <td>
                <?= $m['nama'] ?>
            </td>
            <!-- Menampilkan nombor kad pengenalan ahli -->
            <td>
                <?= $m['nokp'] ?>
            </td>
            <!-- Menampilkan kelas ahli dalam format "ting nama_kelas" -->
            <td>
                <?= $m['ting'] . " " . $m['nama_kelas'] ?>
            </td>
            <!-- Menampilkan kotak semak untuk pengesahan kehadiran -->
            <td>
                <?php
                # Menetapkan status kotak semak berdasarkan kehadiran
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