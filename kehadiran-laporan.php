<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, connection.php dan kawalan-admin.php
include ("header.php");
include ("connection.php");
include ("kawalan-admin.php");

# Tetapkan IDaktiviti lalai
$defaultIDaktiviti = '1';  // Tukar ini kepada IDaktiviti lalai anda

# Menyemak kewujudan data GET['IDaktiviti']
if (empty($_GET['IDaktiviti'])) {
    $_GET['IDaktiviti'] = $defaultIDaktiviti;
}

?>

<div id="filter-overlay"></div>
<div class="header-container">
    <div class="page-header">Laporan Kehadiran Aktiviti</div>
</div>
<main>
    <!-- Borang Carian Aktiviti -->
    <div class="kaunter-info-container kaunter-laporan">
        <!-- Header bagi jadual untuk memaparkan senarai aktiviti -->
        <form action="" method="GET">
            <div class="select-aktiviti-container">
                <label class="label-aktiviti" for="select-aktiviti">Aktiviti: </label>
                <select name='IDaktiviti' id="select-box-aktiviti" class="select-aktiviti">
                    <option selected disabled value>Sila Pilih Aktiviti</option>

                    <?php
                    # Proses memaparkan senarai aktiviti dalam bentuk dropdown list
                    $arahan_sql_pilih = "select * from aktiviti";
                    $laksana_arahan_pilih = mysqli_query($condb, $arahan_sql_pilih);
                    while ($n = mysqli_fetch_array($laksana_arahan_pilih)) {
                        $selected = ($n['IDaktiviti'] == $_GET['IDaktiviti']) ? 'selected' : '';
                        echo "<option value='" . $n['IDaktiviti'] . "' $selected>" . $n['IDaktiviti'] . " | " . $n['nama_aktiviti'] . "</option>";
                    }
                    ?>
                </select>

                <button class="searchBtn" type='submit' value='Cari' data-tooltip="Cari"><i
                        class='bx bx-search'></i></button>
            </div>
        </form>
    </div>

    <?php
    # Syarat tambahan yang akan dimasukkan dalam arahan SQL (query) senarai aktiviti
    $tambahan = "";
    if (!empty($_GET["IDaktiviti"])) {
        # Mengambil nilai data GET di URL
        $IDaktiviti = $_GET["IDaktiviti"];

        # Proses mendapatkan maklumat aktiviti
        $sql_aktiviti = "select * from aktiviti where IDaktiviti='$IDaktiviti'";
        $laksana_aktiviti = mysqli_query($condb, $sql_aktiviti);
        $ma = mysqli_fetch_array($laksana_aktiviti);

        # Mendapatkan tarikh semasa
        $current_date = date('Y-m-d');

        # Mendapatkan analisis kehadiran (bil_hadir & bil_ahli)
        $arahan_SQL = "SELECT 
        (SELECT COUNT(*) FROM kehadiran where IDaktiviti = '" . $ma['IDaktiviti'] . "') AS bil_hadir,
        (SELECT COUNT(*) FROM ahli) AS bil_ahli";
        $laksana_SQL = mysqli_query($condb, $arahan_SQL);
        $da = mysqli_fetch_array($laksana_SQL);

        if ($ma['tarikh_aktiviti'] > $current_date) {
            echo "<div class='laporan-details'>Aktiviti masih belum dijalankan</div>";
            echo "<footer class='bottomed-footer'>
                    <div class='footer-container'>
                        <p class='copyright'>Hakcipta &copy; 2023-2024: SKKPK SMK Bandar Tasik Puteri</p>
                    </div>
                </footer>";
        } else {
            ?>

            <div class="laporan-details">
                <?= $ma['nama_aktiviti'] ?> <br>
                <?= date('d/m/Y', strtotime($ma['tarikh_aktiviti'])) ?> |
                <?= date('H:i', strtotime($ma['masa_mula'])) ?> <br>
                Kehadiran :
                <?= $da['bil_hadir'] . "/" . $da['bil_ahli'] ?> <br>
                Peratus :
                <?php echo number_format(($da['bil_hadir'] / $da['bil_ahli'] * 100), 2); ?>%
            </div>

            <div class="laporan-aktiviti-container">
                <div class="input-carian-container">
                    <div class="carian-laporan">
                        <form id="cari_ahli" action="" method='POST'>
                            <div class="input-carian">
                                <input type="text" name="nama" placeholder="Carian Nama Ahli">
                            </div>
                            <input type="text" name="IDaktiviti" value="<?= $IDaktiviti ?>" hidden>
                        </form>
                        <button class="searchBtn" type='submit' form="cari_ahli" value='Cari' data-tooltip="Cari">
                            <i class='bx bx-search'></i>
                        </button>
                    </div>
                </div>

                <div class="font-size-button">
                    <button class="increase-size-btn" onclick="ubahsaiz(1)" data-tooltip="Tambah Saiz Tulisan"><span
                            class="material-symbols-outlined">text_increase</span></button>
                    <button class="decrease-size-btn" onclick="ubahsaiz(-1)" data-tooltip="Tolak Saiz Tulisan"><span
                            class="material-symbols-outlined">text_decrease</span></button>
                    <button class="reset-font-size" onclick="ubahsaiz(2)">Reset Size</button>
                    <button class="print-btn" onclick="printPage()">Cetak</button>
                </div>
            </div>

            <div class="table-container" id="body">
                <div class="scrollable-table" id="print-area">
                    <table id="saiz" class="table">
                        <thead>
                            <tr>
                                <th>Bil</th>
                                <th>Nama</th>
                                <th>No Kad Pengenalan</th>
                                <th>Kelas</th>
                                <th>Kehadiran</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody id="laporanBody">
                            <?php
                            # Arahan query untuk mencari senarai aktiviti
                            $arahan_papar = "
                        SELECT *, ahli.nokp
                        FROM ahli
                        LEFT JOIN kelas
                        ON ahli.IDkelas = kelas.IDkelas
                        LEFT JOIN kehadiran
                        ON ahli.nokp = kehadiran.nokp
                        and IDaktiviti like '%$IDaktiviti%'
                        ORDER BY ahli.nama ASC
                        ";

                            # Laksana arahan mencari data aktiviti
                            $laksana = mysqli_query($condb, $arahan_papar);
                            $hadir = $tak_hadir = $bil = 0;

                            if (mysqli_num_rows($laksana) > 0) {
                                # Mengambil data yang ditemui
                                while ($m = mysqli_fetch_array($laksana)) {
                                    # Memaparkan senarai nama dalam jadual
                                    echo "<tr>
                                            <td>" . ++$bil . "</td>
                                            <td><div class='profile_img_list_container'><img class='profile_img_list' src='uploads/" . $m['profile_pic'] . "'></div><div class='td-name'>" . $m['nama'] . "</div></td>
                                            <td>" . $m['nokp'] . "</td>
                                            <td>" . $m['ting'] . " " . $m['nama_kelas'] . "</td>
                                            <td align='center' >
                                            ";

                                    if (strlen($m['IDaktiviti']) >= 1) {
                                        echo "<div class='status-hadir'>Hadir</div>";
                                    } else {
                                        echo "<div class='status-tidak-hadir'>Tidak Hadir</div>";
                                    }

                                    echo "<td>
                                            <div class='action-container'>
                                                <div class='edit-mata-container'>
                                                    <button class='editMataBtn open-update-point' data-tooltip='Tambah/Tolak Mata' data-nokp='" . $m['nokp'] . "'>
                                                        <i class='material-symbols-outlined'>stars</i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>";

                                    echo "</td></tr>";
                                }
                            } else {
                                echo "<div class='no-data-text-container'>
                                    <div class='text-area'>Maaf, tiada data untuk dipaparkan...</div>
                                </div>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <footer class="default-footer">
            <div class="footer-container">
                <p class="copyright">Hakcipta &copy; 2023-2024: SKKPK SMK Bandar Tasik Puteri</p>
            </div>
        </footer>
        <?php
        }
    }
    ?>

<!-- Borang untuk memuat naik fail -->
<div class="modal-container" id="modal_mata_container">
    <div class="card modal_mata modal">
        <button class="closeBtn closeMataBtn"><i class='bx bx-x'></i></button>

        <h1>Tambah/Tolak Mata Ahli</h1>

        <form action="mata-kemaskini-proses.php?nokp=<?= $m["nokp"] ?>" method="POST">

            <div class="input_container">
                <div class="input-box">
                    <input type='number' name='mata' value="0" required><br>

                    <!-- Hantar IDaktiviti supaya page tidak "reset" -->
                    <input type='number' name='IDaktiviti' value="<?= $IDaktiviti ?>" hidden><br>
                </div>
            </div>

            <div class="tambah-mata-container">
                <button class="tambahMataBtn close-update-point" type="submit">Kemaskini</button>
            </div>
        </form>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="scripts\select-box-aktiviti.js" defer></script>
<script src="scripts\dialog-update-mata.js" defer></script>

<!-- fungsi data tooltip (petunjuk bagi pengguna bagi butang yang hanya mempunyai icon) -->
<script src="scripts/datatooltip.js" defer></script>

<!-- fungsi mesra pengguna buta warna -->
<script src="scripts/colorblind.js" defer></script>

<!-- fungsi mengubah saiz tulisan bagi kemudahan pengguna dan mencetak jadual-->
<script src="scripts/butang-saiz.js" defer></script>
<script src="scripts/print-page.js" defer></script>

<!-- Proses papar notifikasi apabila kemaskini data -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="scripts/toast.js"></script>

<!-- Fungsi realtime-search -->
<script>
    // Proses data daripada kotak teks carian ahli secara manual
    document.getElementById('cari_ahli').addEventListener('submit', function (event) {
        event.preventDefault(); // Elak daripada refresh halaman selepas submit

        const searchValue = this.value;
        const laporanBody = document.getElementById('laporanBody');
        const IDaktiviti = <?= json_encode($_GET['IDaktiviti']) ?>;  // Ambil nilai IDaktiviti dari pembolehubah PHP

        // Lakukan carian menggunakan AJAX (atau penghantaran borang)
        var xhr = new XMLHttpRequest();
        var formData = new FormData(this); // Ambil data daripada borang carian

        // Hantar permintaan POST ke server untuk mencari data ahli
        xhr.open('POST', "search-laporan.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Jika permintaan berjaya, kemaskini jadual  dengan data yang baru
                laporanBody.innerHTML = xhr.responseText;

                // Pasang semula event listeners untuk kandungan yang dimuat secara dinamik
                attachEventListeners();
            }
        };
        // Hantar data borang ke server
        xhr.send(formData);
    });

    function attachEventListeners() {
        // Pasang event listener untuk editMataBtn menggunakan event delegation
        document.getElementById('laporanBody').addEventListener('click', function (event) {
            const editMataBtn = event.target.closest('.open-update-point');
            if (editMataBtn) {
                const nokp = editMataBtn.dataset.nokp;
                console.log('editMataBtn clicked for nokp: ' + nokp);

                // Papar modal atau lakukan tindakan lain di sini
                showModal(nokp);
            }
        });
    }

    // Pemasangan awal event listeners
    attachEventListeners();

    function showModal(nokp) {
        const modalContainer = document.getElementById('modal_mata_container');
        const modalForm = modalContainer.querySelector('form');

        // Tetapkan nilai nokp dalam action form atau input tersembunyi
        const formAction = `mata-kemaskini-proses.php?nokp=${nokp}`;
        modalForm.setAttribute('action', formAction);

        // Papar modal
        modalContainer.classList.add("show");

        // Tambah event listener untuk butang tutup dalam modal
        const closeModalBtn = modalContainer.querySelector('.closeMataBtn');
        closeModalBtn.addEventListener('click', function () {
            modalContainer.classList.remove("show");
        });
    }
</script>

<!-- Elak daripada resubmission borang apabila refresh -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>