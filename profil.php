<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php dan connection.php
include ("header.php");
include ("connection.php");

# Menyemak kewujudan nilai pembolehubah session['nokp']
if (empty($_SESSION["nokp"])) {
    # Jika nilai session nokp tidak wujud/kosong, aturcara akan diberhentikan
    die("<script>alert('Sila Log Masuk');
        window.location.href='logout.php'; </script>");
}
?>

<div id="filter-overlay"></div>
<div class="header-container">
    <div class="page-header">Profil</div>
</div>
<main>
    <div class="user_and_point_container">
        <div class="card user-details">

            <div class="container">
                <div class="profile_pic_wrapper">
                    <div class="profile_pic_container">
                        <img src="uploads/<?= $_SESSION["profile_pic"] ?>">
                    </div>
                </div>

                <div class="user_info">
                    <div class="primary-text">
                        <?= $_SESSION['nama'] ?>
                    </div>
                    <div class="secondary-text">
                        <?= $_SESSION['nokp'] ?>
                    </div>
                    <div class="secondary-text">
                        <?= $_SESSION['ting'] ?>
                        <?= $_SESSION['nama_kelas'] ?>
                    </div>
                    <div class="secondary-text">
                        <?= $_SESSION['tahap'] ?>
                    </div>

                    <div class="edit_profile-container">
                        <a href='profile-kemaskini-borang.php?'>
                            <button class="edit_profileBtn">Kemaskini Profil</button>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <div class="card carta-mata">
            <div class="container">
                <div class='view-mata' id="view-mata"></div>
            </div>
            <script src="scripts\progressbar.min.js"></script>
            <script src="scripts\point-progress.js" defer></script>
        </div>
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

                            $startDate = new DateTime($m['tarikh_aktiviti'] . ' ' . $m['masa_mula']);
                            $endDate = new DateTime($m['tarikh_aktiviti'] . ' ' . $m['masa_tamat']);
                            $now = new DateTime();

                            if (mysqli_num_rows($laksana_hadir) == 1) {
                                echo "<div class='status-hadir'>Hadir</div>";
                            } else {
                                // Semak jika tarikh_aktiviti sudah lepas, jika ya, papar ikon 'X'
                                if ($endDate < $now) {
                                    echo "<div class='status-tidak-hadir'>Tidak Hadir</div>";
                                } else {
                                    $targetDate = $startDate->format('Y-m-d H:i:s');
                                    // Display a real-time countdown
                                    echo '<div class="coundownText" id="countdown_' . $m['IDaktiviti'] . '"></div>';
                                    echo '<script defer>
                                    var countDownDate_' . $m['IDaktiviti'] . ' = new Date("' . $targetDate . '").getTime();

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
                                            document.getElementById("countdown_' . $m['IDaktiviti'] . '").innerHTML = \' <button class="sahkendiriBtn" ><a href="profil-sahkendiri.php?IDaktiviti=' . $m['IDaktiviti'] . '"><i class="bx bx-user-check"></i>Rekod</a></button>\';
                                        }
                                    }, 1000);
                                </script>';

                                }
                            }
                            echo "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </tr>
    </div>
</main>

<footer class="default-footer">
    <div class="footer-container">
        <p class="copyright">Hakcipta &copy; 2023-2024: SKKPK SMK Bandar Tasik
            Puteri</p>
    </div>
</footer>

<!-- fungsi mesra pengguna buta warna -->
<script src="scripts\colorblind.js" defer></script>

<script src="scripts\footer-script.js"></script>

<!-- Proses papar notifikasi apabila kemaskini data -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="scripts\toast.js"></script>