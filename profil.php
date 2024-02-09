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

<div class="user-detail">
    <p>
        Nama:
        <?= $_SESSION['nama'] ?> <br>
        No. Kad Pengenalan:
        <?= $_SESSION['nokp'] ?> <br>
    </p>
</div>

<div class="container-table">
    <tr>
        <div class="rekod-kehadiran">
            <h3>Rekod Kehadiran</h3>

            <!-- Header bagi jadual untuk memaparkan senarai aktiviti -->
            <table id='saiz'>
                <caption>
                    Pengesahan Kendiri hanya boleh dilakukan pada tarikh aktiviti dilaksanakan sahaja
                </caption>

                <thead>
                    <tr>
                        <th>Nama Aktiviti</th>
                        <th>Tarikh | Masa</th>
                        <th>Kehadiran</th>
                    </tr>
                </thead>

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
                        <td>" . $m['tarikh_aktiviti'] . " | " . $m['masa_mula'] . "</td>
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

            </table>
        </div>

        <div class="carta-mata">

            <div class="container">
                <div class="view-mata">
                    <div class="value-container">0</div>
                </div>
            </div>
        </div>
    </tr>
</div>