<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, connection.php dan kawalan-admin.php
include ("header.php");
include ("connection.php");
include ("kawalan-admin.php");
?>

<div class="page-header">Laporan Kehadiran Aktiviti</div>
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
                        echo "<option value='" . $n['IDaktiviti'] . "'>
            " . $n['IDaktiviti'] . " | " . $n['nama_aktiviti'] . "
            </option>";
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

        # Mendapatkan analisis kehadiran (bil_hadir & bil_ahli)
        $arahan_SQL = "SELECT 
    (SELECT COUNT(*) FROM kehadiran where IDaktiviti = '" . $ma['IDaktiviti'] . "') AS bil_hadir,
    (SELECT COUNT(*) FROM ahli) AS bil_ahli ";
        $laksana_SQL = mysqli_query($condb, $arahan_SQL);
        $da = mysqli_fetch_array($laksana_SQL);
        ?>

        <div class="laporan-details">
            <?= $ma['nama_aktiviti'] ?> <br>
            <?= date('d/m/Y', strtotime($ma['tarikh_aktiviti'])) ?> |
            <?= date('H:i', strtotime($ma['masa_mula'])) ?> <br>
            Kehadiran :
            <?= $da['bil_hadir'] . "/" . $da['bil_ahli'] ?> <br>
            Peratus :
            <?php echo number_format(($da['bil_hadir'] / $da['bil_ahli'] * 100), 2);
            ?>
        </div>

        <div class="laporan-aktiviti-container">
            <div class="input-carian-container">
                <div class="input-carian">
                    <input type="text" id="searchAhli" name="nama" placeholder="Carian Nama Ahli">
                </div>
            </div>

            <div class="font-size-button">
                <button class="resize-btn" onclick="ubahsaiz(1)" data-tooltip="Ubah Saiz Tulisan"><i
                        class='bx bx-font-size'></i></button>
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
                        ORDER BY ahli.nama
                        ";

                        # Laksana arahan mencari data aktiviti
                        $laksana = mysqli_query($condb, $arahan_papar);
                        $hadir = $tak_hadir = $bil = 0;

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
                        echo "</table>";
    } ?>
                </tbody>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="scripts\select-box-aktiviti.js" defer></script>
    <script src="scripts\dialog-update-mata.js" defer></script>
</main>

<!-- Borang untuk memuat naik fail -->
<div class="modal-container" id="modal_mata_container">
    <div class="card modal_mata modal">
        <button class="closeBtn closeMataBtn"><i class='bx bx-x'></i></button>

        <h1>Tambah Mata Ahli</h1>

        <form action="mata-kemaskini-proses.php?nokp=<?= $m["nokp"] ?>" method="POST">

            <div class="input_container">
                <div class="input-box">
                    <input type='number' name='mata' value="0" required><br>

                    <!-- Hantar IDaktiviti supaya page tidak "reset" -->
                    <input type='number' name='IDaktiviti' value="<?= $IDaktiviti ?>" hidden><br>
                </div>
            </div>

            <div class="tambah-mata-container">
                <button class="tambahMataBtn close-update-point" type="submit">Tambah</button>
            </div>
        </form>

    </div>
</div>

<!-- fungsi mengubah saiz tulisan bagi kemudahan pengguna dan mencetak jadual-->
<script src="scripts\butang-saiz.js" defer></script>
<script src="scripts\print-page.js" defer></script>

<!-- Proses papar notifikasi apabila kemaskini data -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="scripts\toast.js"></script>

<!-- Elak daripada resubmission borang apabila refresh -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<!-- Fungsi realtime-search -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('searchAhli').addEventListener('input', function () {
            const searchValue = this.value;
            const laporanBody = document.getElementById('laporanBody');

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'search-laporan.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function () {
                if (this.status === 200) {
                    laporanBody.innerHTML = this.responseText;

                    // Re-attach event listeners for dynamically loaded content
                    attachEventListeners();
                }
            }

            xhr.send('nama=' + encodeURIComponent(searchValue));
        });

        function attachEventListeners() {
            // Attach event listener for editMataBtn using event delegation
            document.getElementById('laporanBody').addEventListener('click', function (event) {
                const editMataBtn = event.target.closest('.open-update-point');
                if (editMataBtn) {
                    const nokp = editMataBtn.dataset.nokp;
                    console.log('editMataBtn clicked for nokp: ' + nokp);

                    // Show modal or perform other actions here
                    showModal(nokp);
                }
            });
        }

        // Initial attachment of event listeners
        attachEventListeners();

        function showModal(nokp) {
            const modalContainer = document.getElementById('modal_mata_container');
            const modalForm = modalContainer.querySelector('form');

            // Set the nokp value in the form action or hidden input
            const formAction = `mata-kemaskini-proses.php?nokp=${nokp}`;
            modalForm.setAttribute('action', formAction);

            // Show the modal
            modalContainer.classList.add("show");

            // Add event listener for close button inside the modal
            const closeModalBtn = modalContainer.querySelector('.closeMataBtn');
            closeModalBtn.addEventListener('click', function () {
                modalContainer.classList.remove("show");
            });
        }
    });

</script>