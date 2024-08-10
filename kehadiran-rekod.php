<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, kawalan-admin.php dan connection.php
include ("header.php");
include ("kawalan-admin.php");
include ("connection.php");

# Set IDaktiviti default jika tidak diberikan
$defaultIDaktiviti = '1';  // Tukar ini kepada IDaktiviti default anda

# Menyemak kewujudan data GET['IDaktiviti']
if (empty($_GET['IDaktiviti'])) {
    $_GET['IDaktiviti'] = $defaultIDaktiviti;
}

if (!empty($_GET['IDaktiviti'])) {
    # Proses mendapatkan data aktiviti berdasarkan IDaktiviti yang diterima
    $sql_aktiviti = "SELECT * FROM aktiviti WHERE IDaktiviti = '" . $_GET['IDaktiviti'] . "'";
    $laksana_aktiviti = mysqli_query($condb, $sql_aktiviti);
    $ma = mysqli_fetch_array($laksana_aktiviti);
}

$currentDate = date('Y-m-d');
?>

<div id="filter-overlay"></div>
<div class="header-container">
    <div class="page-header">Laman Rekod Kehadiran Kaunter Urusetia</div>
</div>
<main>
    <div class="kaunter-info-container">
        <!-- Borang carian aktiviti -->
        <form action='' method='GET'>
            <div class="select-aktiviti-container">
                <label for="select-aktiviti">Aktiviti: </label>
                <select name='IDaktiviti' id="select-box-aktiviti" class="select-aktiviti">
                    <option selected disabled value>Sila Pilih Aktiviti</option>

                    <?php
                    # Proses memaparkan senarai aktiviti dalam bentuk dropdown list
                    $arahan_sql_pilih = "SELECT * FROM aktiviti";
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

        <?php if ($currentDate < $ma['tarikh_aktiviti']) { ?>
            <!-- Mesej jika aktiviti belum dijalankan -->
            <div class='aktiviti-details'>Aktiviti masih belum dijalankan</div>
        <?php } else { ?>
            <?php if (!empty($_GET["IDaktiviti"])) { ?>
                <!-- Header bagi jadual untuk memaparkan senarai aktiviti -->
                <div class="aktiviti-details">
                    Aktiviti: <?= $ma['nama_aktiviti'] ?><br>
                    Tarikh: <?= $ma['tarikh_aktiviti'] ?><br>
                    Masa: <?= date('H:i', strtotime($ma['masa_mula'])) ?><br>
                </div>
            </div>

            <div class="rekod-container">
                <!-- Borang untuk merekod kehadiran -->
                <form action='kehadiran-rekod-proses.php' method='POST' align='center'>
                    <div class="input-rekod">
                        <input class="input-rekod" type='text' name='nokp' placeholder="No. Kad Pengenalan" autocomplete="off">
                        <!-- Hantar IDaktiviti supaya page tidak "reset" -->
                        <input type='number' name='IDaktiviti' value="<?= $_GET['IDaktiviti'] ?>" hidden><br>
                    </div>

                    <button type='submit' class="rekodBtn"><i class='bx bx-user-check'></i>Rekod</button>
                </form>
            </div>

            <div class="table-container table-rekod">
                <div class="scrollable-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Bil.</th>
                                <th>Nama</th>
                                <th>No. Kad Pengenalan</th>
                                <th>Kelas</th>
                                <th>Masa Hadir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $bil = 0;

                            # Memaparkan data kehadiran dalam bentuk jadual
                            $arahan_sql_kehadiran = "SELECT * FROM ahli, aktiviti, kehadiran, kelas 
                                                     WHERE ahli.nokp=kehadiran.nokp 
                                                     AND ahli.IDkelas=kelas.IDkelas 
                                                     AND aktiviti.IDaktiviti=kehadiran.IDaktiviti 
                                                     AND kehadiran.IDaktiviti='" . $_GET['IDaktiviti'] . "' 
                                                     ORDER BY kehadiran.masa_hadir DESC";
                            $laksana_kehadiran = mysqli_query($condb, $arahan_sql_kehadiran);

                            if (mysqli_num_rows($laksana_kehadiran) > 0) {
                                while ($m = mysqli_fetch_array($laksana_kehadiran)) {
                                    echo "<tr>
                                        <td>" . ++$bil . "</td>
                                        <td>" . $m['nama'] . "</td>
                                        <td>" . $m['nokp'] . "</td>
                                        <td>" . $m['ting'] . " " . $m['nama_kelas'] . "</td>
                                        <td>" . $m['masa_hadir'] . "</td>
                                    </tr>";
                                }
                            } else {
                                echo "<div class='no-data-text-container'>
                                    <div class='text-area'>Maaf, data tidak wujud...</div>
                                </div>";
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="scripts/select-box-aktiviti.js" defer></script>
</main>

<footer class="default-footer">
    <div class="footer-container">
        <p class="copyright">Hakcipta &copy; 2024-2025: SKKPK SMK Bandar Tasik Puteri</p>
    </div>
</footer>

<!-- fungsi data tooltip (petunjuk bagi pengguna bagi butang yang hanya mempunyai icon) -->
<script src="scripts/datatooltip.js" defer></script>

<!-- fungsi mesra pengguna buta warna -->
<script src="scripts/colorblind.js" defer></script>

<!-- Proses papar notifikasi apabila kemaskini data -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="scripts/toast.js"></script>

<script src="scripts/fo0ter-script.js"></script>

<!-- Elak daripada resubmission borang apabila refresh -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>