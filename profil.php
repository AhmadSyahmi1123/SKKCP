<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php dan connection.php untuk header halaman dan sambungan pangkalan data
include ("header.php");
include ("connection.php");

# Menyemak jika nilai dalam pembolehubah session 'nokp' wujud
if (empty($_SESSION["nokp"])) {
    # Jika nilai session 'nokp' tidak wujud, paparkan amaran dan arahkan pengguna ke halaman logout
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
                        <!-- Memaparkan gambar profil pengguna -->
                        <img src="uploads/<?= $_SESSION["profile_pic"] ?>">
                    </div>
                </div>

                <div class="user_info">
                    <!-- Memaparkan maklumat pengguna -->
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
                        <!-- Butang untuk mengemaskini profil pengguna -->
                        <a href='profile-kemaskini-borang.php?'>
                            <button class="edit_profileBtn">Kemaskini Profil</button>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <div class="card carta-mata">
            <div class="container">
                <!-- Tempat untuk memaparkan carta mata -->
                <div class='view-mata' id="view-mata"></div>
            </div>
            <!-- Memasukkan skrip untuk carta mata -->
            <script src="scripts/progressbar.min.js"></script>
            <script src="scripts/point-progress.js" defer></script>
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
                        # Arahan query untuk mendapatkan senarai aktiviti
                        $arahan_papar = "SELECT * FROM aktiviti";
                        # Melaksanakan arahan untuk mendapatkan data aktiviti
                        $laksana = mysqli_query($condb, $arahan_papar);

                        if (mysqli_num_rows($laksana) > 0) {
                            # Mengambil dan memaparkan setiap aktiviti dalam jadual
                            while ($m = mysqli_fetch_array($laksana)) {
                                echo "<tr>
                                    <td>" . $m['nama_aktiviti'] . "</td>
                                    <td>" . date('d/m/Y', strtotime($m['tarikh_aktiviti'])) . "</td>
                                    <td>" . date('H:i', strtotime($m['masa_mula'])) . "</td>
                                    <td>" . date('H:i', strtotime($m['masa_tamat'])) . "</td>
                                    <td align='center'>";

                                # Arahan untuk memeriksa kehadiran pengguna bagi setiap aktiviti
                                $arahan_sql_hadir = "SELECT * FROM kehadiran WHERE nokp = '" . $_SESSION['nokp'] . "' AND IDaktiviti = '" . $m['IDaktiviti'] . "'";
                                # Melaksanakan arahan untuk memeriksa kehadiran
                                $laksana_hadir = mysqli_query($condb, $arahan_sql_hadir);

                                # Menyediakan objek DateTime untuk masa aktiviti dan masa semasa
                                $startDate = new DateTime($m['tarikh_aktiviti'] . ' ' . $m['masa_mula']);
                                $endDate = new DateTime($m['tarikh_aktiviti'] . ' ' . $m['masa_tamat']);
                                $now = new DateTime();

                                if (mysqli_num_rows($laksana_hadir) == 1) {
                                    # Jika pengguna hadir, paparkan status 'Hadir'
                                    echo "<div class='status-hadir'>Hadir</div>";
                                } else {
                                    # Jika aktiviti sudah tamat, paparkan status 'Tidak Hadir'
                                    if ($endDate < $now) {
                                        echo "<div class='status-tidak-hadir'>Tidak Hadir</div>";
                                    } else {
                                        $targetDate = $startDate->format('Y-m-d H:i:s');
                                        # Paparkan kiraan masa secara langsung sehingga aktiviti bermula
                                        echo '<div class="coundownText" id="countdown_' . $m['IDaktiviti'] . '"></div>';
                                        echo '<script defer>
                                            var countDownDate_' . $m['IDaktiviti'] . ' = new Date("' . $targetDate . '").getTime();

                                            // Kemas kini kiraan masa setiap 1 saat
                                            var x_' . $m['IDaktiviti'] . ' = setInterval(function() {
                                                var now = new Date().getTime();

                                                // Kira jarak masa antara sekarang dan tarikh kiraan
                                                var distance = countDownDate_' . $m['IDaktiviti'] . ' - now;

                                                // Kira hari, jam, minit dan saat
                                                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                                // Paparkan keputusan dalam elemen dengan id "countdown_' . $m['IDaktiviti'] . '"
                                                document.getElementById("countdown_' . $m['IDaktiviti'] . '").innerHTML = days + "d " + hours + "h "
                                                + minutes + "m " + seconds + "s ";

                                                // Jika kiraan masa tamat, paparkan butang untuk pengesahan kehadiran
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
                        } else {
                            echo "<div class='no-data-text-container'>
                                <div class='text-area'>Maaf, tiada data untuk dipaparkan...</div>
                            </div>";
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
        <p class="copyright">Hakcipta &copy; 2024-2025: SKKPK SMK Bandar Tasik Puteri</p>
    </div>
</footer>

<!-- Memasukkan skrip untuk menyokong buta warna dan pengendalian footer -->
<script src="scripts/colorblind.js" defer></script>
<script src="scripts/footer-script.js"></script>

<!-- Skrip untuk memaparkan notifikasi apabila data dikemaskini -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="scripts/toast.js"></script>