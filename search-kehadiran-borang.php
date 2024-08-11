<?php
// Memanggil fail connection.php untuk sambungan ke pangkalan data
include ("connection.php");

// Memeriksa jika borang dihantar dan nama tidak kosong
if (isset($_POST['nama'])) {
    // Mendapatkan IDaktiviti dan nama dari borang
    $IDaktiviti = $_POST['IDaktiviti'];
    $nama = mysqli_real_escape_string($condb, $_POST['nama']);

    // Arahan SQL untuk mendapatkan maklumat ahli bersama kehadiran mereka berdasarkan nama dan IDaktiviti
    $arahan_papar = "SELECT *, ahli.nokp, ahli.nama, kelas.ting, kelas.nama_kelas, kehadiran.IDaktiviti 
                    FROM ahli
                    LEFT JOIN kelas ON ahli.IDkelas = kelas.IDkelas
                    LEFT JOIN kehadiran ON ahli.nokp = kehadiran.nokp AND kehadiran.IDaktiviti = '$IDaktiviti'
                    WHERE 1=1 AND ahli.nama LIKE '%$nama%'
                    ORDER BY ahli.nama ASC";

    // Melaksanakan arahan SQL
    $laksana_kehadiran = mysqli_query($condb, $arahan_papar);
    $bil = 0;

    if (mysqli_num_rows($laksana_kehadiran) > 0) {
        // Mengambil dan memaparkan semua data kehadiran yang ditemui
        while ($m = mysqli_fetch_array($laksana_kehadiran)) { ?>
            <tr>
                <td><?= ++$bil; ?></td>
                <td><?= $m['nama'] ?></td>
                <td><?= $m['nokp'] ?></td>
                <td><?= $m['ting'] . " " . $m['nama_kelas'] ?></td>
                <td>
                    <?php
                    $tanda = $m['IDaktiviti'] != null ? "checked" : "";
                    ?>
                    <input <?= $tanda ?> type="checkbox" name="kehadiran[]" value="<?= $m['nokp'] ?>"
                        style="width:30px; height:30px;">
                </td>
            </tr>
            <?php
        }
    } else { ?>
        <div class='no-data-text-container'>
            <div class='text-area'>Maaf, tiada data untuk dipaparkan</div>
        </div>
    <?php }
}
?>