<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php dan connection.php
include("header.php");
include("connection.php");

# Menyemak kewujudan nilai pembolehubah session['nokp']
if (empty($_SESSION["nokp"])) {
    # Jika nilai session nokp tidak wujud/kosong, aturcara akan diberhentikan
    die("<script>alert('Sila Log Masuk');
        window.location.href='logout.php'; </script>");
}
?>

<div class="user-details">
    Nama:
    <?= $_SESSION['nama'] ?>
    <br>
    No. Kad Pengenalan:
    <?= $_SESSION['nokp'] ?>
</div>

<div class="container-profil-table">
    <tr>
        <!-- Header bagi jadual untuk memaparkan senarai aktiviti -->
        <div class="scrollable-profil-table">
            <table id='saiz' class="profil-table">
                <thead>
                    <tr>
                        <th>Nama Aktiviti</th>
                        <th>Tarikh</th>
                        <th>Masa</th>
                        <th>Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    # Arahan query untuk mencari senarai aktiviti
                    $arahan_papar = "select * from aktiviti";
                    # Laksana arahan mencari data senarai aktiviti
                    $laksana = mysqli_query($condb, $arahan_papar);

                    # Mengambil data yang ditemui
                    while ($m = mysqli_fetch_array($laksana)) {
                        # Memaparkan senarai nama dalam jadual
                        echo "<tr>
                        <td>" . $m['nama_aktiviti'] . "</td>
                        <td>" . date('d/m/Y', strtotime($m['tarikh_aktiviti'])) . "</td>
                        <td>" . date('H:i', strtotime($m['masa_mula'])) . "</td>
                        <td align='center'>";

                        # Arahan mendapatkan data kehadiran ahli bagi setiap aktiviti
                        $arahan_sql_hadir = "select * from kehadiran where nokp = '" . $_SESSION['nokp'] . "' and IDaktiviti = '" . $m['IDaktiviti'] . "'";
                        # Melaksanakan arahan mendapatkan data kehadiran ahli
                        $laksana_hadir = mysqli_query($condb, $arahan_sql_hadir);

                        $today = date("Y-m-d");

                        if (mysqli_num_rows($laksana_hadir) == 1) {
                            echo "&#9989;";
                        } else {
                            // Semak jika tarikh_aktiviti sudah lepas, jika ya, papar ikon 'X'
                            if ($m['tarikh_aktiviti'] < $today) {
                                echo "&#10060; <br>";
                            } else {
                                // Jika masih belum tarikh_aktiviti,
                                // kira berapa hari lagi
                                $now = new DateTime($today);
                                $futureDate = new DateTime($m['tarikh_aktiviti']);

                                $interval = $futureDate->diff($now);
                                $daysLeft = $interval->days;

                                // Jika hari yang tinggal = 0 (tarikh $today == tarikh_aktiviti), paparkan link pengesahan kehadiran kendiri
                                if ($daysLeft == 0) {
                                    // Pengesahan kehadiran kendiri
                                    echo "<a href='profil-sahkendiri.php?IDaktiviti=" . $m['IDaktiviti'] . "'> [ PENGESAHAN KENDIRI ] </a>";
                                } else {
                                    echo $daysLeft . " hari lagi <br>";
                                }
                            }
                        }
                        echo "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="carta-mata">

            <div class="container">
                <div id="view-mata"></div>
            </div>
            <script src="scripts\progressbar.min.js"></script>
            <script src="scripts\point-progress.js" defer></script>
        </div>
    </tr>
</div>