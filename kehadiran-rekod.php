<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, kawalan-admin.php dan connection.php
include ("header.php");
include ("kawalan-admin.php");
include ("connection.php");

$masa = date("H:i:s");

# Menyemak kewujudan data POST
if (!empty($_POST["nokp"])) {
    # Menyemak jika nokp yang dimasukkan telah wujud dalam pangkalan data
    $arahan_sql_semak = "select * from ahli where nokp = '" . $_POST['nokp'] . "' ";
    # Laksana arahan semak
    $laksana_arahan_semak = mysqli_query($condb, $arahan_sql_semak);
    if (mysqli_num_rows($laksana_arahan_semak) != 1) {
        # Jika nokp yang dimasukkan telah wujud
        $message = "No. Kad Pengenalan yang dimasukkan tiada dalam sistem";
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
    } else {
        # Menyemak jika nokp yang dimasukkan telah direkodkan dalam pangkalan data kehadiran
        $arahan_semak = "select * from kehadiran where nokp='" . $_POST['nokp'] . "' and IDaktiviti='" . $_GET['IDaktiviti'] . "' limit 1";
        $laksana_arahan = mysqli_query($condb, $arahan_semak);

        if (mysqli_num_rows($laksana_arahan) == 1) {
            $message = "Anda telah mengesahkan kehadiran sebelum ini";
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
        } else {
            # Arahan beri mata kepada pengguna berdasarkan masa mereka hadir 
            $command_masa = "SELECT * FROM aktiviti WHERE IDaktiviti = " . $_GET['IDaktiviti'];
            $laksana_masa = mysqli_query($condb, $command_masa);
            $get_aktiviti = mysqli_fetch_assoc($laksana_masa);

            $masa_mula = strtotime($get_aktiviti['masa_mula']);
            $masa_tamat = strtotime($get_aktiviti['masa_tamat']);

            $masa_hadir = strtotime($masa);

            $points = 10;

            if ($masa_hadir >= $masa_mula && $masa_hadir <= $masa_tamat) {

                $masa_lewat = round(($masa_hadir - $masa_mula) / 60);

                if ($masa_lewat <= 3) {
                    $points = 5;
                } elseif ($masa_lewat <= 5) {
                    $points = 3;
                } else {
                    $points = 1;
                }
            }

            # Menyimpan data kehadiran
            $simpan_data = mysqli_query($condb, "insert into kehadiran (IDaktiviti, nokp, masa_hadir) values ('" . $_GET['IDaktiviti'] . "', '" . $_POST['nokp'] . "', '$masa')");

            # Menyemak jika proses penyimpanan data berjaya
            if ($simpan_data) {
                # Arahan kemaskini mata murid 
                $kemaskini_mata = "UPDATE ahli SET mata = mata + $points WHERE nokp = '" . $_POST['nokp'] . "'";
                # Laksana arahan kemaskini mata murid
                $laksana_kemaskini_mata = mysqli_query($condb, $kemaskini_mata);

                $message = "Kehadiran berjaya direkod!";
                echo '<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>';
                echo "<script>
                        // Create an instance of Notyf
                        let notyf = new Notyf();

                        // Display an error notification
                        notyf.success({
                            message: '$message',
                            duration: 3000,
                            dismissible: true,
                            position: {x: 'right', y: 'top'}
                        });
                    </script>";
            } else {
                $message = "Kehadiran Gagal Direkod!";
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
    }
} else {
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $message = "Sila Isi No. Kad Pengenalan!";
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
            <form action='' method='POST' align='center'>
                <div class="input-rekod">
                    <input class="input-rekod" type='text' name='nokp' placeholder="No. Kad Pengenalan" autocomplete="off">
                </div>

                <button type='submit' class="rekodBtn"><i class='bx bx-user-check'></i>Rekod</button>
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