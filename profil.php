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
                        <th>Masa Mula</th>
                        <th>Masa Tamat</th>
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
                        <td>" . date('H:i', strtotime($m['masa_tamat'])) . "</td>
                        <td align='center'>";

                        # Arahan mendapatkan data kehadiran ahli bagi setiap aktiviti
                        $arahan_sql_hadir = "select * from kehadiran where nokp = '" . $_SESSION['nokp'] . "' and IDaktiviti = '" . $m['IDaktiviti'] . "'";
                        # Melaksanakan arahan mendapatkan data kehadiran ahli
                        $laksana_hadir = mysqli_query($condb, $arahan_sql_hadir);

                        $today = date('d/m/Y');
                        $masa = date("H:i:s");

                        if (mysqli_num_rows($laksana_hadir) == 1) {
                            echo "&#9989;";
                        } else {
                            // Semak jika tarikh_aktiviti sudah lepas, jika ya, papar ikon 'X'
                            if ($m['tarikh_aktiviti'] < $today && $m['masa_tamat'] < $masa) {
                                echo "&#10060; <br>";
                            } else {
                                if ($today == date('d/m/Y', strtotime($m['tarikh_aktiviti'])) && $masa != $m['tarikh_aktiviti']) {
                                    // Display a real-time countdown
                                    echo '<div id="countdown_' . $m['IDaktiviti'] . '"></div>';
                                    echo '<script>
                                        var countDownDate_' . $m['IDaktiviti'] . ' = new Date("' . $m['tarikh_aktiviti'] . 'T' . $m['masa_mula'] . '").getTime();

                                        // Update the count down every 1 second
                                        var x_' . $m['IDaktiviti'] . ' = setInterval(function() {
                                            var now = new Date().getTime();

                                            // Find the distance between now and the count down date
                                            var distance = countDownDate_' . $m['IDaktiviti'] . ' - now;

                                            // Time calculations for days, hours, minutes and seconds
                                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                            // Output the result in an element with id="countdown_' . $m['IDaktiviti'] . '"
                                            document.getElementById("countdown_' . $m['IDaktiviti'] . '").innerHTML = days + "d " + hours + "h "
                                            + minutes + "m " + seconds + "s ";

                                            // If the count down is over, display link for self-confirmation of attendance
                                            if (distance <= 0) {
                                                clearInterval(x_' . $m['IDaktiviti'] . ');
                                                document.getElementById("countdown_' . $m['IDaktiviti'] . '").innerHTML = \' <a href="profil-sahkendiri.php?IDaktiviti=' . $m['IDaktiviti'] . '">[ PENGESAHAN KEHADIRAN ]</a>\';
                                            }
                                        }, 1000);
                                    </script>';

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