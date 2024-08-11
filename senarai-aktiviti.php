<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, connection.php dan kawalan-admin.php
include ("header.php");
include ("connection.php");
include ("kawalan-admin.php");
?>

<div id="filter-overlay"></div>
<div class="header-container">
    <div class="page-header">Senarai Aktiviti</div>
</div>
<main>
    <div class="upload-aktiviti-container">
        <div class="input-carian-container">
            <div class="carian-aktiviti">
                <form id="cari_aktiviti" action='' method='POST'>
                    <div class="input-carian">
                        <input type="text" name='nama_aktiviti' placeholder='Carian Aktiviti'>
                    </div>
                </form>

                <button class="searchBtn" type='submit' form="cari_aktiviti" value='Cari' data-tooltip="Cari">
                    <i class='material-symbols-outlined'>search</i>
                </button>
                <div class="upload-container">
                    <button id="open-aktiviti" class="uploadBtn" data-tooltip="Tambah Aktiviti/Perjumpaan">
                        <i class='material-symbols-outlined'>playlist_add</i>
                    </button>
                </div>
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

    <!-- Header bagi jadual untuk memaparkan senarai aktiviti -->
    <div class="table-container" id="body">
        <div class="scrollable-table" id="print-area">
            <table class="table" id="saiz">

                <thead>
                    <tr>
                        <th>Nama Aktiviti</th>
                        <th>Tarikh</th>
                        <th>Masa Mula</th>
                        <th>Masa Tamat</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody id="aktivitiBody">
                    <?php
                    # Arahan query untuk mencari senarai aktiviti
                    $arahan_papar = "SELECT * FROM aktiviti";

                    # Laksana arahan mencari senarai aktiviti
                    $laksana = mysqli_query($condb, $arahan_papar);

                    if (mysqli_num_rows($laksana) > 0) {
                        # Mengambil data yang ditemui
                        while ($m = mysqli_fetch_array($laksana)) {

                            # Memaparkan senarai aktiviti dalam jadual
                            echo "<tr>
                        <td>" . $m['nama_aktiviti'] . "</td>
                        <td>" . date('d/m/Y', strtotime($m['tarikh_aktiviti'])) . "</td>
                        <td>" . date('H:i', strtotime($m['masa_mula'])) . "</td>
                        <td>" . date('H:i', strtotime($m['masa_tamat'])) . "</td>
        ";

                            # Memaparkan navigasi untuk kemaskini dan hapus data aktiviti
                            echo "<td>
                    <div class='action-container'>
                        <div class='edit-container'>
                            <button class='editBtn' data-tooltip='Kemaskini'>
                                <a href='aktiviti-kemaskini-borang.php?IDaktiviti=" . $m['IDaktiviti'] . "'><i class='bx bx-edit'></i></a>
                            </button>
                        </div>

                        <div class='delete-container'>
                            <button class='deleteBtn' data-tooltip='Hapus'>
                                <a href='aktiviti-padam-proses.php?IDaktiviti=" . $m['IDaktiviti'] . "' onclick=\"return confirm('Anda pasti anda ingin memadam data ini?')\"><i class='bx bx-trash'></i></a>
                            </button>
                        </div>

                        <div class='hadir-container'>
                            <button class='hadirBtn' data-tooltip='Pengesahan Kehadiran' data-tarikh-aktiviti='" . $m['tarikh_aktiviti'] . "'>
                                <a href='kehadiran-borang.php?IDaktiviti=" . $m['IDaktiviti'] . "'><i class='bx bx-list-check'></i></a>
                            </button>
                        </div>
                    </div>
                </td>
        </tr>";
                        }
                    } else {
                        # Jika tiada data ditemui, papar mesej "Sorry, no data available"
                        echo "<div class='no-data-text-container'>
                                <div class='text-area'>Maaf, tiada data untuk dipaparkan...</div>
                            </div>";
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="scripts\dialog-script-aktiviti.js" defer></script>
</main>

<footer class="default-footer">
    <div class="footer-container">
        <p class="copyright">Hakcipta &copy; 2023-2024: SKKPK SMK Bandar Tasik Puteri</p>
    </div>
</footer>

<!-- Borang daftar aktiviti -->
<div class="modal-container" id="modal_aktiviti_container">
    <div class="card modal_aktiviti modal">

        <button id="closeAddAktivitiBtn" class="closeBtn"><i class='bx bx-x'></i></button>
        <form class="daftar_aktiviti_borang" method="POST" onsubmit="daftarAktiviti(event)">

            <!-- Tajuk Antaramuka Log Masuk -->
            <h1>Daftar Aktiviti Baru</h1>

            <label for="input-aktiviti">Nama Aktiviti*</label>
            <div class="input-box">
                <input id="input-aktiviti" type='text' name='nama_aktiviti' placeholder="Nama Aktiviti" required>
            </div>

            <label for="input-tarikh">Tarikh Aktiviti*</label>
            <div class="input-box">
                <input id="input-tarikh" type='date' name='tarikh_aktiviti' min='<?= date("Y-m-d") ?>' required>
            </div>

            <label for="input-masa-mula">Masa Mula*</label>
            <div class="input-box">
                <input id="input-masa-mula" type='time' name='masa_mula' placeholder="Masa Mula" required>
            </div>

            <label for="input-masa-tamat">Masa Tamat*</label>
            <div class="input-box">
                <input id="input-masa-tamat" type='time' name='masa_tamat' placeholder="Masa Tamat" required>
            </div>

            <button class="addBtn" type='submit'>Tambah</button>

        </form>
    </div>
</div>

<!-- fungsi data tooltip (petunjuk bagi pengguna bagi butang yang hanya mempunyai icon) -->
<script src="scripts\datatooltip.js" defer></script>

<!-- fungsi mesra pengguna buta warna -->
<script src="scripts\colorblind.js" defer></script>

<!-- fungsi mengubah saiz tulisan bagi kemudahan pengguna dan mencetak jadual-->
<script src="scripts\butang-saiz.js" defer></script>
<script src="scripts\print-page.js" defer></script>

<!-- Proses papar notifikasi apabila kemaskini data -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="scripts\toast.js"></script>

<!-- Proses daftar aktiviti -->
<script>
    // Fungsi hantar data ke aktiviti-daftar-proses.php
    function daftarAktiviti(event) {
        event.preventDefault(); // Mengelakkan borang dihantar secara lalai
        var form = document.querySelector('.daftar_aktiviti_borang'); // Dapatkan elemen borang
        var formData = new FormData(form); // Membuat objek FormData dengan data borang
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "aktiviti-daftar-proses.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                var urlParams = new URLSearchParams(window.location.search);
                urlParams.set('notificationType', 'success');
                urlParams.set('notificationMessage', 'Aktiviti berjaya ditambah.');
                window.location.href = "senarai-aktiviti.php?" + urlParams.toString();
            } else {
                var urlParams = new URLSearchParams(window.location.search);
                urlParams.set('notificationType', 'error');
                urlParams.set('notificationMessage', 'Ralat! Aktiviti gagal ditambah.');
                window.location.href = "senarai-aktiviti.php?" + urlParams.toString();
            }
        };
        xhr.onerror = function () {
            alert("An error occurred. Please try again."); // Papar mesej ralat
        };
        xhr.send(formData); // Hantar objek FormData
    }
</script>

<!-- Skrip untuk fungsi carian aktiviti -->
<script>
    // Proses data daripada kotak teks carian ahli secara manual
    document.getElementById('cari_aktiviti').addEventListener('submit', function (event) {
        event.preventDefault(); // Elak daripada refresh halaman selepas submit

        // Lakukan carian menggunakan AJAX (atau penghantaran borang)
        var xhr = new XMLHttpRequest();
        var formData = new FormData(this); // Ambil data daripada borang carian

        // Hantar permintaan POST ke server untuk mencari data ahli
        xhr.open('POST', "search-aktiviti.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Jika permintaan berjaya, kemaskini carta pendahulu dengan data yang baru
                document.getElementById('aktivitiBody').innerHTML = xhr.responseText;
            }
        };
        xhr.send(formData); // Hantar data borang ke server
    });
</script>

<!-- Skrip untuk semak tarikh aktiviti sebelum pengesahan kehadiran -->
<script>
    document.querySelectorAll('.hadirBtn').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent the default action

            const tarikhAktiviti = this.getAttribute('data-tarikh-aktiviti');
            const activityDate = new Date(tarikhAktiviti);
            const currentDate = new Date();

            // Semak jika tarikh aktiviti sudah tiba
            if (activityDate > currentDate) {
                var urlParams = new URLSearchParams(window.location.search);
                urlParams.set('notificationType', 'error');
                urlParams.set('notificationMessage', 'Tarikh aktiviti belum tiba!');
                window.location.href = "senarai-aktiviti.php?" + urlParams.toString();
            } else {
                // Jika tarikh sudah tiba, benarkan proses ini berlaku
                window.location.href = this.querySelector('a').href;
            }
        });
    });
</script>

<!-- Elak daripada resubmission borang apabila refresh -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>