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
                        <td>" . $m['tarikh_aktiviti'] . "</td>
                        <td>" . $m['masa_mula'] . "</td>
                        <td align='center'>";

                    # Arahan mendapatkan data kehadiran ahli bagi setiap aktiviti
                    $arahan_sql_hadir = "select * from kehadiran where nokp = '" . $_SESSION['nokp'] . "' and IDaktiviti = '" . $m['IDaktiviti'] . "'";
                    # Melaksanakan arahan mendapatkan data kehadiran ahli
                    $laksana_hadir = mysqli_query($condb, $arahan_sql_hadir);

                    if (mysqli_num_rows($laksana_hadir) == 1) {
                        echo "&#9989;";
                    } else {
                        echo "&#10060; <br>";

                        if (date("Y-m-d") == $m['tarikh_aktiviti']) {
                            # Pengesahan kehadiran kendiri
                            echo "<a href='profil-sahkendiri.php?IDaktiviti=" . $m['IDaktiviti'] . "'>
                [ PENGESAHAN KENDIRI ] </a>";
                        }
                    }

                    echo "</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="carta-mata">

            <div class="container">
                <div id="view-mata"></div>
            </div>
            <script src="scripts\progressbar.min.js"></script>
            <script src="scripts\point-progress.js" defer></script>
        </div>
    </tr>
</div>