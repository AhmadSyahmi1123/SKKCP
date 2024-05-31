<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, connection.php dan kawalan-admin.php
include ("header.php");
include ("connection.php");
include ("kawalan-admin.php");
?>

<!-- Header bagi jadual untuk memaparkan senarai ahli -->
<div class="page-header">Senarai Ahli</div>
<main>

    <div class="searchNupload-container">
        <div class="input-carian-container">
            <form action='' method="POST">
                <div class="input-carian">
                    <input type='text' name='nama' placeholder='Carian Nama Ahli'>
                </div>

                <button class="searchBtn" type='submit' value='Cari' data-tooltip="Cari">
                    <i class='material-symbols-outlined'>search</i>
                </button>
            </form>
        </div>
        <div class="upload-container">
            <button id="open-upload" class="uploadBtn" data-tooltip="Muat Naik Ahli">
                <i class='material-symbols-outlined'>group_add</i>
            </button>

            <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
        </div>
    </div>

    <div class="table-container">
        <div class="scrollable-table">
            <table class="table">
                <thead>

                    <tr>
                        <th>Nama</th>
                        <th>No. Kad Pengenalan</th>
                        <th>Kelas</th>
                        <th>Katalaluan</th>
                        <th>Tahap</th>
                        <th>Mata</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    # Syarat tambahan yang akan dimasukkan dalam arahan(query) senarai ahli
                    $cari_ahli = "";
                    if (!empty($_POST["nama"])) {
                        $cari_ahli = " and ahli.nama like '%" . $_POST['nama'] . "%'";
                    }

                    # Arahan query untuk mencari senarai nama ahli
                    $arahan_papar = "select * from ahli, kelas where ahli.IDkelas = kelas.IDkelas $cari_ahli ";

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

                        # Memaparkan senarai nama dalam jadual
                        echo "<tr>
    <td><div class='profile_img_list_container'><img class='profile_img_list' src='uploads/" . $m['profile_pic'] . "'></div><div class='td-name'>" . $m['nama'] . "</div></td>
    <td>" . $m['nokp'] . "</td>
    <td>" . $m['ting'] . " " . $m['nama_kelas'] . "</td>
    <td>" . $m['katalaluan'] . "</td>
    <td>" . $m['tahap'] . "</td>
    <td>" . $m['mata'] . "</td>
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

                    <h2>Upload Text File</h2>

                    <p>Select a .txt file to upload:</p>

                    <input type="file" name="data_ahli" id="file" accept=".txt, .text">

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

<!-- Proses papar notifikasi apabila kemaskini data -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script defer>
    let notyf = new Notyf();

    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const notificationType = urlParams.get('notificationType');
        const notificationMessage = urlParams.get('notificationMessage');

        // Display the notification using JavaScript
        if (notificationType && notificationMessage) {
            if (notificationType === 'success') {
                notyf.success({
                    message: notificationMessage,
                    duration: 3000,
                    dismissible: true,
                    position: {
                        x: 'right',
                        y: 'top'
                    }
                });
            } else if (notificationType === 'error') {
                notyf.error({
                    message: notificationMessage,
                    duration: 3000,
                    dismissible: true,
                    position: {
                        x: 'right',
                        y: 'top'
                    }
                });
            }

            // Remove notification parameters from the URL
            history.replaceState(null, null, window.location.pathname);
        }
    });
</script>

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