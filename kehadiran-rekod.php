<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, kawalan-admin.php dan connection.php
include ("header.php");
include ("kawalan-admin.php");
include ("connection.php");

# Menyemak kewujudan data GET['IDaktiviti']
if (!empty($_GET['IDaktiviti'])) {
    # Proses mendapatkan data aktiviti
    $sql_aktiviti = "select * from aktiviti where IDaktiviti = '" . $_GET['IDaktiviti'] . "'";
    $laksana_aktiviti = mysqli_query($condb, $sql_aktiviti);
    $ma = mysqli_fetch_array($laksana_aktiviti);
}
?>

<div class="page-header">Laman Rekod Kehadiran Kaunter Urusetia</div>
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
                    $arahan_sql_pilih = "select * from aktiviti";
                    $laksana_arahan_pilih = mysqli_query($condb, $arahan_sql_pilih);

                    while ($n = mysqli_fetch_array($laksana_arahan_pilih)) {
                        echo "<option value='" . $n['IDaktiviti'] . "'>" . $n['IDaktiviti'] . " | " . $n['nama_aktiviti'] . "</option>";
                    }
                    ?>
                </select>
                <button class="searchBtn" type='submit' value='Cari' data-tooltip="Cari"><i
                        class='bx bx-search'></i></button>
            </div>
        </form>

        <?php if (!empty($_GET["IDaktiviti"])) { ?>
            <!-- Header bagi jadual untuk memaparkan senarai aktiviti -->
            <div class="aktiviti-details">
                Aktiviti:
                <?= $ma['nama_aktiviti'] ?><br>
                Tarikh:
                <?= $ma['tarikh_aktiviti'] ?> <br>
                Masa:
                <?= date('H:i', strtotime($ma['masa_mula'])) ?> <br>
            </div>
        </div>

        <div class="rekod-container">
            <form action='kehadiran-rekod-proses.php' method='POST' align='center'>
                <div class="input-rekod">
                    <input class="input-rekod" type='text' name='nokp' placeholder="No. Kad Pengenalan" autocomplete="off">

                    <!-- Hantar IDaktiviti supaya page tidak "reset" -->
                    <input type='number' name='IDaktiviti' value="<?= $_GET['IDaktiviti'] ?>" hidden><br>
                </div>

                <button onclick="rekodKehadiran();" type='submit' class="rekodBtn"><i
                        class='bx bx-user-check'></i>Rekod</button>
            </form>
        </div>

        <div class="table-container">
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
                        $arahan_sql_kehadiran = "select * from ahli, aktiviti, kehadiran, kelas where ahli.nokp=kehadiran.nokp and ahli.IDkelas=kelas.IDkelas and aktiviti.IDaktiviti=kehadiran.IDaktiviti and kehadiran.IDaktiviti='" . $_GET['IDaktiviti'] . "' order by kehadiran.masa_hadir DESC";
                        $laksana_kehadiran = mysqli_query($condb, $arahan_sql_kehadiran);

                        while ($m = mysqli_fetch_array($laksana_kehadiran)) {
                            echo "<tr>
                <td>" . ++$bil . "</td>
                <td>" . $m['nama'] . "</td>
                <td>" . $m['nokp'] . "</td>
                <td>" . $m['ting'] . " " . $m['nama_kelas'] . "</td>
                <td>" . $m['masa_hadir'] . "</td>
              </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="scripts\select-box-aktiviti.js" defer></script>
</main>

<!-- fungsi data tooltip (petunjuk bagi pengguna bagi butang yang hanya mempunyai icon) -->
<script src="scripts\datatooltip.js" defer></script>

<!-- Proses papar notifikasi apabila kemaskini data -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="scripts\toast.js"></script>

<!-- Elak daripada resubmission borang apabila refresh -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>