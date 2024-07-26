<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, connection.php dan kawalan-admin.php
include ("header.php");
include ("connection.php");
include ("kawalan-admin.php");
?>

<div id="filter-overlay"></div>
<!-- Header bagi jadual untuk memaparkan senarai ahli -->
<div class="header-container">
    <div class="page-header">Senarai Ahli</div>
</div>
<main>
    <div class="upload-ahli-container">
        <div class="input-carian-container">
            <div class="input-carian">
                <input type='text' id="searchAhli" name='nama' placeholder='Carian Nama Ahli' autocomplete="off">
            </div>
        </div>

        <div class="upload-container">
            <button id="open-upload" class="uploadBtn" data-tooltip="Muat Naik Ahli">
                <i class='material-symbols-outlined'>group_add</i>
            </button>

            <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
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
            <table class="table" id="saiz">
                <thead>

                    <tr>
                        <th>Nama</th>
                        <th>No. Kad Pengenalan</th>
                        <th>Kelas</th>
                        <th>Katalaluan</th>
                        <th>Tahap</th>
                        <th>Mata</th>
                        <th>Kehadiran</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody id="ahliBody">
                    <?php
                    # Arahan query untuk mencari senarai nama ahli
                    $arahan_papar = "select * from ahli, kelas where ahli.IDkelas = kelas.IDkelas ORDER BY ahli.nama ASC";

                    # Laksana arahan mencari data ahli
                    $laksana = mysqli_query($condb, $arahan_papar);

                    # Mengambil data yang ditemui
                    while ($m = mysqli_fetch_array($laksana)) {

                        # Umpukkan data kepda tatasusunan bagi tujuan kemaskini ahli
                        $data_get = array(
                            'nama' => $m['nama'],
                            'profile_pic' => $m['profile_pic'],
                            'nokp' => $m['nokp'],
                            'katalaluan' => $m['katalaluan'],
                            'tahap' => $m['tahap'],
                            'IDkelas' => $m['IDkelas'],
                            'ting' => $m['ting'],
                            'nama_kelas' => $m['nama_kelas'],
                            'mata' => $m['mata']
                        );

                        $nokp = $m['nokp'];
                        $sql_count = "SELECT COUNT(*) as count FROM kehadiran WHERE nokp = '$nokp'";
                        $exec_count = mysqli_query($condb, $sql_count);
                        $row_hadir = mysqli_fetch_assoc($exec_count);
                        $count_hadir = $row_hadir['count'];

                        $sql_aktiviti = "SELECT COUNT(*) as count FROM aktiviti";
                        $exec_aktiviti = mysqli_query($condb, $sql_aktiviti);
                        $row_aktiviti = mysqli_fetch_assoc($exec_aktiviti);
                        $count_aktiviti = $row_aktiviti['count'];

                        # Memaparkan senarai nama dalam jadual
                        echo "<tr>
                                <td><div class='profile_img_list_container'><img class='profile_img_list' src='uploads/" . $m['profile_pic'] . "'></div><div class='td-name'>" . $m['nama'] . "</div></td>
                                <td>" . $m['nokp'] . "</td>
                                <td>" . $m['ting'] . " " . $m['nama_kelas'] . "</td>
                                <td>" . $m['katalaluan'] . "</td>
                                <td>" . $m['tahap'] . "</td>
                                <td>" . $m['mata'] . "</td>
                                <td>$count_hadir/$count_aktiviti</td>
                            ";


                        # Memaparkan navigasi untuk kemaskini dan hapus data ahli
                        echo "<td>
                    <div class='action-container'>
                        <div class='edit-container'>
                            <button class='editBtn' data-tooltip='Kemaskini'>
                                <a href='ahli-kemaskini-borang.php?" . http_build_query($data_get) . "'><i class='bx bx-edit'></i></a>
                            </button>
                        </div>

                        <div class='delete-container'>
                            <button class='deleteBtn' data-tooltip='Hapus'>
                                <a href='ahli-padam-proses.php?nokp=" . $m['nokp'] . "' onclick=\"return confirm('Anda pasti anda ingin memadam data ini?')\">
                                    <i class='bx bx-trash'></i>
                                </a>                        
                            </button>
                        </div>
                    </div>
        </td>
        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Borang untuk memuat naik fail -->
    <div class="modal-container" id="modal_upload_container">
        <div class="card modal_upload modal">
            <button id="closeUploadFileBtn" class="closeBtn"><i class='bx bx-x'></i></button>

            <form class="upload-form" target="dummyframe" method="POST" enctype="multipart/form-data" accept=".txt">
                <div class="upload-box">

                    <h2>Muat Naik Data Ahli</h2>

                    <p>Sila pilih fail berformat .txt untuk dimuatnaik:</p>

                    <div class="choose-file-btn">
                        <input type="file" name="data_ahli" id="file" accept=".txt, .text">
                    </div>

                    <div class="uploadBtn-container">
                        <button onclick="daftarAhli()" id="close-upload" class="upload_fileBtn" type="submit">
                            <i class='material-symbols-outlined'>upload</i> Muat Naik
                        </button>
                    </div>

                </div>

            </form>
        </div>
    </div>

    <script src="scripts\dialog-script-upload.js" defer></script>
</main>

<footer class="default-footer">
    <div class="footer-container">
        <p class="copyright">Hakcipta &copy; 2024-2025: SKKPK SMK Bandar Tasik Puteri</p>
    </div>
</footer>

<!-- fungsi data tooltip (petunjuk bagi pengguna bagi butang yang hanya mempunyai icon) -->
<script src="scripts\datatooltip.js" defer></script>

<!-- fungsi mesra pengguna buta warna -->
<script src="scripts\colorblind.js" defer></script>

<!-- fungsi mengubah saiz tulisan bagi kemudahan pengguna dan mencetak jadual -->
<script src="scripts\butang-saiz.js" defer></script>
<script src="scripts\print-page.js" defer></script>

<!-- Proses papar notifikasi apabila kemaskini data -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="scripts\toast.js"></script>

<!-- Proses daftar aktiviti -->
<script>
    // Fungsi hantar data ke aktiviti-daftar-proses.php
    function daftarAhli() {
        var form = document.querySelector('.upload-form'); // Get the form element
        var formData = new FormData(form); // Create FormData object with form data

        var fileInput = document.querySelector('input[type="file"]'); // Get the file input element
        var file = fileInput.files[0]; // Get the first file

        // Validate file type
        if (!file || file.type !== "text/plain") {
            var urlParams = new URLSearchParams(window.location.search);
            urlParams.set('notificationType', 'error');
            urlParams.set('notificationMessage', 'Ralat! Sila Masukkan Fail Format .txt!');
            window.location.href = "senarai-ahli.php?" + urlParams.toString();
            return; // Stop the function if file type is not .txt
        }


        var xhr = new XMLHttpRequest();
        xhr.open("POST", "upload.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                var urlParams = new URLSearchParams(window.location.search);
                urlParams.set('notificationType', 'success');
                urlParams.set('notificationMessage', 'Ahli-ahli berjaya didaftar.');
                window.location.href = "senarai-ahli.php?" + urlParams.toString();
            } else {
                var urlParams = new URLSearchParams(window.location.search);
                urlParams.set('notificationType', 'error');
                urlParams.set('notificationMessage', 'Ralat! Ahli-ahli gagal didaftar.');
                window.location.href = "senarai-ahli.php?" + urlParams.toString();
            }
        };
        xhr.onerror = function () {
            alert("An error occurred. Please try again."); // Show error message
        };
        xhr.send(formData); // Send the FormData object
    }
</script>

<!-- Elak daripada resubmission borang apabila refresh -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<script>
    document.getElementById('searchAhli').addEventListener('input', function () {
        const searchValue = this.value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'search-ahli.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            if (this.status === 200) {
                document.getElementById('ahliBody').innerHTML = this.responseText;
            }
        }

        xhr.send('nama=' + encodeURIComponent(searchValue));
    });
</script>