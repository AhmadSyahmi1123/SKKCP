<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, connection.php dan kawalan-admin.php
include("header.php");
include("connection.php");
include("kawalan-admin.php");
?>

<!-- Header bagi jadual untuk memaparkan senarai ahli -->
<h3 align='center'>Senarai Ahli</h3>

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
    <div class="upload-container">
        <button id="open-upload" class="uploadBtn" data-tooltip="Muat Naik Ahli">
            <i class="fa fa-upload"></i>
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
                        'nokp' => $m['nokp'],
                        'katalaluan' => $m['katalaluan'],
                        'tahap' => $m['tahap'],
                        'IDkelas' => $m['IDkelas'],
                        'ting' => $m['ting'],
                        'nama_kelas' => $m['nama_kelas'],
                    );

                    # Memaparkan senarai nama dalam jadual
                    echo "<tr>
        <td>" . $m['nama'] . "</td>
        <td>" . $m['nokp'] . "</td>
        <td>" . $m['ting'] . " " . $m['nama_kelas'] . "</td>
        <td>" . $m['katalaluan'] . "</td>
        <td>" . $m['tahap'] . "</td>
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
                                <a href='ahli-padam-proses.php?nokp=" . $m['nokp'] . "' onClick=\" return confirm('Anda pasti anda ingin
                                    memadam data ini?')\"><i class='bx bx-trash'></i></a>
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
    <div class="modal">
        <button class="closeBtn"><i class='bx bx-x'></i></button>

        <form action="upload.php" target="dummyframe" method="POST" enctype="multipart/form-data" accept=".txt">
            <div class="upload-box">

                <h2>Upload Text File</h2>

                <p>Select a .txt file to upload:</p>

                <input type="file" name="data_ahli" id="file" accept=".txt, .text">

                <button id="close-upload" class="upload_fileBtn" type="submit" name="btn-upload">
                    <i class="fa fa-upload"></i>
                    Upload File
                </button>

            </div>

        </form>
    </div>
</div>

<script src="scripts\dialog-script-upload.js" defer></script>