<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, connection.php dan kawalan-admin.php
include("header.php");
include("connection.php");
include("kawalan-admin.php");

?>
<h3 align='center'> Senarai Aktiviti </h3>

<div class="searchNupload-container">
    <div class="input-carian-container">
        <form action='' method='POST'>
            <div class="input-carian">
                <input type="text" name='nama_aktiviti' placeholder='Carian Aktiviti'>
            </div>

            <button class="searchBtn" type='submit' value='Cari' data-tooltip="Cari">
                <i class='bx bx-search'></i>
            </button>
        </form>
    </div>

    <div class="upload-container">
        <button id="open-dialog" class="uploadBtn" data-tooltip="Tambah Aktiviti/Perjumpaan">
            <i class='bx bx-list-plus'></i>
        </button>

        <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>

        <div class="modal-container" id="modal_container">
            <div class="modal">
                <!-- Borang Daftar Masuk -->
                <form action='aktiviti-daftar-proses.php' target="dummyframe" method="POST">

                    <!-- Tajuk Antaramuka Log Masuk -->
                    <h1>Daftar Aktiviti Baru</h1>

                    <label for="input-aktiviti">Nama Aktiviti*</label>
                    <div class="input-box">
                        <input id="input-aktiviti" type='text' name='nama_aktiviti' placeholder="Nama Aktiviti"
                            required>
                    </div>

                    <label for="input-tarikh">Tarikh Aktiviti*</label>
                    <div class="input-box">
                        <input id="input-tarikh" type='date' name='tarikh_aktiviti' min='<?= date("d-m-Y") ?>'
                            required>
                    </div>

                    <label for="input-masa">Masa Mula*</label>
                    <div class="input-box">
                        <input id="input-masa" type='time' name='masa_mula' placeholder="Masa Mula" required>
                    </div>

                    <input class="addBtn" type='submit' value='Tambah'>

                </form>

                <button id="close-dialog" class="closeBtn"><i class='bx bx-x'></i></button>
                
            </div>
        </div>
    </div>
</div>

<!-- Header bagi jadual untuk memaparkan senarai aktiviti -->
<div class="table-container">
    <div class="scrollable-table">
        <table class="table">

            <thead>
                <tr>
                    <th>Nama Aktiviti</th>
                    <th>Tarikh</th>
                    <th>Masa</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                # Syarat tambahan yang akan dimasukkan dalam arahan(query) senarai aktiviti
                $tambahan = "";
                if (!empty($_POST["nama_aktiviti"])) {
                    $tambahan = "where nama_aktiviti like '%" . $_POST['nama_aktiviti'] . "%'";
                }

                # Araham query untuk mencari senarai aktiviti
                $arahan_papar = "select * from aktiviti $tambahan";

                # Laksana arahan mencari senarai aktiviti
                $laksana = mysqli_query($condb, $arahan_papar);

                # Mengambil data yang ditemui
                while ($m = mysqli_fetch_array($laksana)) {

                    # Memaparkan senarai aktiviti dalam jadual
                    echo "<tr>
                        <td>" . $m['nama_aktiviti'] . "</td>
                        <td>" . date('d/m/Y', strtotime($m['tarikh_aktiviti'])) . "</td>
                        <td>" . $m['masa_mula'] . "</td>
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
                                <a href='aktiviti-padam-proses.php?IDaktiviti=" . $m['IDaktiviti'] . "' onClick=\" return
                                    confirm('Anda pasti anda ingin memadam data ini?')\"><i class='bx bx-trash'></i></a>
                            </button>
                        </div>

                        <div class='hadir-container'>
                            <button class='hadirBtn' data-tooltip='Pengesahan Kehadiran'>
                                <a href='kehadiran-borang.php?IDaktiviti=" . $m['IDaktiviti'] . "'><i class='bx bx-list-check'></i></a>
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
<script src="scripts\dialog-script.js" defer></script>