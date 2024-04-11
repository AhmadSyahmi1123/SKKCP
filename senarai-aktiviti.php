<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, connection.php dan kawalan-admin.php
include("header.php");
include("connection.php");
include("kawalan-admin.php");

?>

<div class="page-header">Senarai Aktiviti</div>
<main>

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
            <button id="open-aktiviti" class="uploadBtn" data-tooltip="Tambah Aktiviti/Perjumpaan">
                <i class='material-symbols-outlined'>playlist_add</i>
            </button>

            <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>

            <div class="modal-container" id="modal_aktiviti_container">
                <div class="card modal_aktiviti modal">

                    <button id="closeAddAktivitiBtn" class="closeBtn"><i class='bx bx-x'></i></button>
                    <!-- Borang Daftar Masuk -->
                    <form method="POST">

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

                        <label for="input-masa">Masa Mula*</label>
                        <div class="input-box">
                            <input id="input-masa" type='time' name='masa_mula' placeholder="Masa Mula" required>
                        </div>`

                        <label for="input-masa">Masa Tamat*</label>
                        <div class="input-box">
                            <input id="input-masa" type='time' name='masa_tamat' placeholder="Masa Tamat" required>
                        </div>

                        <input class="addBtn" type='submit' value='Tambah'>

                    </form>
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
                        <th>Masa Mula</th>
                        <th>Masa Tamat</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    # Syarat tambahan yang akan dimasukkan dalam arahan(query) senarai aktiviti
                    $cari_aktiviti = "";
                    if (!empty($_POST["nama_aktiviti"])) {
                        $tambahcari_aktivitian = "where nama_aktiviti like '%" . $_POST['nama_aktiviti'] . "%'";
                    }

                    # Araham query untuk mencari senarai aktiviti
                    $arahan_papar = "select * from aktiviti $cari_aktiviti";

                    # Laksana arahan mencari senarai aktiviti
                    $laksana = mysqli_query($condb, $arahan_papar);

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
                                <a href='aktiviti-padam-proses.php?IDaktiviti=" . $m['IDaktiviti'] . "' onClick=\"return confirm('Anda pasti anda ingin memadam data ini?')\">
                                    <i class='bx bx-trash'></i>
                                </a>
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
    <script src="scripts\dialog-script-aktiviti.js" defer></script>

    <!-- Dapatkan data aktiviti realtime -->
    <script src="scripts\displayAktivitiRealtime.js" defer></script>
</main>

<!-- Proses papar notifikasi apabila kemaskini data -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script defer>
    // Create an instance of Notyf
    let notyf = new Notyf();

    document.addEventListener('DOMContentLoaded', function() {
        // Check if there's a notification message in sessionStorage
        const notificationType = '<?php echo isset($_SESSION['notificationType']) ? $_SESSION['notificationType'] : '' ?>';
        const notificationMessage = '<?php echo isset($_SESSION['notificationMessage']) ? $_SESSION['notificationMessage'] : '' ?>';

        if (notificationMessage) {
            // Display the notification using JavaScript
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

            // Clear the notification session variables
            <?php unset($_SESSION['notificationType']); ?>
            <?php unset($_SESSION['notificationMessage']); ?>
        }
    });
</script>

<!-- Proses daftar aktiviti ke dalam pangkalan data -->
<?php
# Menyemak jika data POST wujud
if (!empty($_POST)) {
    # Arahan SQL (query) untuk menyimpan data aktiviti baru
    $arahan_sql_simpan = "insert into aktiviti ( nama_aktiviti, tarikh_aktiviti, masa_mula, masa_tamat ) 
    values ('" . strtoupper($_POST['nama_aktiviti']) . "', '" . $_POST['tarikh_aktiviti'] . "', '" . $_POST['masa_mula'] . "', '" . $_POST['masa_tamat'] . "')";

    # Laksana arahan SQL menyimpan data aktiviti baru
    $laksana_arahan_simpan = mysqli_query($condb, $arahan_sql_simpan);

    # Menguji jika proses menyimpan data berjaya atau tidak
    if ($laksana_arahan_simpan) {
        $message = "Pendaftaran Aktiviti Berjaya!";
        # Jika berjaya, papar popup dan buka fail senarai-aktiviti.php
        echo '<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>';
        echo "<script>
                // Create an instance of Notyf
                let notyf = new Notyf();

                // Display an success notification
                notyf.success({
                    message: '$message',
                    duration: 3000,
                    dismissible: true,
                    position: {x: 'right', y: 'top'}
                });
            </script>";
    } else {
        $message = "Pendaftaran Aktiviti Gagal!";
        # Jika gagal, papar popup dan buka fail aktiviti-daftar-borang.php
        echo '<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>';
        echo "<script>
                // Create an instance of Notyf
                let notyf = new Notyf();

                // Display an error notification
                notyf.error({
                    message: '$message',
                    duration: 3000,
                    dismissible: true,
                    position: {x: 'right', y: 'top'}
                });
            </script>";
    }
} else {
    $message = "Sila Lengkapkan Maklumat!";
    # Semak jika ada borang dihantar
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        # Jika pengguna tidak mengisi data, papar popup dan buka fail aktiviti-daftar-borang.php
        echo '<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>';
        echo "<script>
                // Create an instance of Notyf
                let notyf = new Notyf();

                // Display an error notification
                notyf.error({
                    message: '$message',
                    duration: 3000,
                    dismissible: true,
                    position: {x: 'right', y: 'top'}
                });
            </script>";
    }
}
?>