<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, connection.php dan kawalan-admin.php
include ("header.php");
include ("connection.php");
include ("kawalan-admin.php");

# Mendapatkan maklumat aktiviti dari pangkalan data
$arahan_sql_aktiviti = "SELECT * FROM aktiviti WHERE IDaktiviti='" . $_GET['IDaktiviti'] . "' ";
$laksana_aktiviti = mysqli_query($condb, $arahan_sql_aktiviti);
$n = mysqli_fetch_array($laksana_aktiviti);
?>

<div id="filter-overlay"></div>
<div class="header-container">
    <div class="page-header">Pengesahan Kehadiran Ahli</div>
</div>
<main>
    <div class="kehadiran-details">
        Nama Aktiviti : <?= $n['nama_aktiviti'] ?> <br>
        Tarikh | Masa : <?= $n['tarikh_aktiviti'] ?> | <?= date('H:i', strtotime($n['masa_mula'])) ?> <br>
    </div>

    <div class="borang-container">
        <div class="searchNupload-container">
            <div class="input-carian-container">
                <div class="carian-ahli">
                    <form id="cari_ahli" action="" method='POST'>
                        <div class="input-carian">
                            <input type="text" name="nama" placeholder="Carian Nama Ahli">
                        </div>
                        <input type="text" name="IDaktiviti" value="<?= $_GET['IDaktiviti'] ?>" hidden>
                    </form>
                    <button class="searchBtn" type='submit' form="cari_ahli" value='Cari' data-tooltip="Cari">
                        <i class='bx bx-search'></i>
                    </button>
                </div>
            </div>

            <div class="font-size-button">
                <button class="increase-size-btn" onclick="ubahsaiz(1)" data-tooltip="Tambah Saiz Tulisan">
                    <span class="material-symbols-outlined">text_increase</span>
                </button>
                <button class="decrease-size-btn" onclick="ubahsaiz(-1)" data-tooltip="Tolak Saiz Tulisan">
                    <span class="material-symbols-outlined">text_decrease</span>
                </button>
                <button class="reset-font-size" onclick="ubahsaiz(2)">Reset Size</button>
                <button class="print-btn" onclick="printPage()">Cetak</button>
            </div>
        </div>

        <form action="kehadiran-proses.php?IDaktiviti=<?= $_GET['IDaktiviti'] ?>" method="POST">
            <div class="table-container" id="body">
                <div class="scrollable-table" id="print-area">
                    <table class="table" id="saiz">
                        <thead>
                            <tr>
                                <th>Bil</th>
                                <th>Nama</th>
                                <th>No Kad Pengenalan</th>
                                <th>Kelas</th>
                                <th>Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody id="kehadiranBody">
                            <?php
                            # Syarat tambahan yang akan dimasukkan dalam arahan(query) senarai ahli
                            $cari_ahli = "";
                            if (!empty($_POST["nama"])) {
                                $cari_ahli = " AND ahli.nama LIKE '%" . $_POST['nama'] . "%'";
                            }

                            # Arahan untuk mendapatkan data kehadiran setiap ahli
                            $arahan_sql_kehadiran = "SELECT *, ahli.nokp, ahli.nama, kelas.ting, kelas.nama_kelas, kehadiran.IDaktiviti 
                                                    FROM ahli
                                                    LEFT JOIN kelas ON ahli.IDkelas = kelas.IDkelas
                                                    LEFT JOIN kehadiran ON ahli.nokp = kehadiran.nokp AND kehadiran.IDaktiviti = '" . $_GET["IDaktiviti"] . "'
                                                    WHERE 1=1
                                                    ORDER BY ahli.nama ASC";

                            # Laksana arahan untuk memproses data
                            $laksana_kehadiran = mysqli_query($condb, $arahan_sql_kehadiran);
                            $bil = 0;

                            if (mysqli_num_rows($laksana_kehadiran) > 0) {
                                # Mengambil dan memaparkan semua data kehadiran yang ditemui
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

<footer class="default-footer">
    <div class="footer-container">
        <p class="copyright">Hakcipta &copy; 2023-2024: SKKPK SMK Bandar Tasik Puteri</p>
    </div>
</footer>

<!-- Fungsi data tooltip (petunjuk bagi pengguna bagi butang yang hanya mempunyai icon) -->
<script src="scripts\datatooltip.js" defer></script>

<!-- Fungsi mesra pengguna buta warna -->
<script src="scripts\colorblind.js" defer></script>

<!-- Fungsi mengubah saiz tulisan bagi kemudahan pengguna dan mencetak jadual-->
<script src="scripts\butang-saiz.js" defer></script>
<script src="scripts\print-page.js" defer></script>

<!-- Proses untuk mencari ahli -->
<script>
    // Proses data daripada kotak teks carian ahli secara manual
    document.getElementById('cari_ahli').addEventListener('submit', function (event) {
        event.preventDefault(); // Elak daripada refresh halaman selepas submit

        // Lakukan carian menggunakan AJAX (atau penghantaran borang)
        var xhr = new XMLHttpRequest();
        var formData = new FormData(this); // Ambil data daripada borang carian

        // Hantar permintaan POST ke server untuk mencari data ahli
        xhr.open('POST', "search-kehadiran-borang.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Jika permintaan berjaya, kemaskini carta pendahulu dengan data yang baru
                document.getElementById('kehadiranBody').innerHTML = xhr.responseText;
            }
        };
        xhr.send(formData); // Hantar data borang ke server
    });
</script>