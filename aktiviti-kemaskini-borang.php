<?php
# Memulakan sesi PHP untuk menyimpan maklumat pengguna
session_start();

# Memanggil fail header.php untuk antaramuka pengguna, kawalan-admin.php untuk kawalan akses, dan connection.php untuk sambungan pangkalan data
include ("header.php");
include ("kawalan-admin.php");
include ("connection.php");

# Menyemak jika terdapat data GET yang dihantar. Jika tidak, alihkan ke senarai-aktiviti.php
if (empty($_GET)) {
    die("<script>window.location.href='senarai-aktiviti.php';</script>");
}

# Mendapatkan maklumat aktiviti dari pangkalan data berdasarkan IDaktiviti yang dihantar melalui GET
$arahan_sql_pilihan = "select * from aktiviti where IDaktiviti='" . $_GET['IDaktiviti'] . "' ";

# Melaksanakan arahan SQL untuk mendapatkan maklumat aktiviti
$laksana_arahan = mysqli_query($condb, $arahan_sql_pilihan);
$m = mysqli_fetch_array($laksana_arahan);
?>

<div id="filter-overlay"></div>
<main>
    <div class="card wrapper_kemaskini">
        <div class="kemaskini-borang">
            <h1>Kemaskini Aktiviti</h1>

            <!-- Borang untuk mengemaskini maklumat aktiviti -->
            <form action="aktiviti-kemaskini-proses.php?IDaktiviti=<?= $m['IDaktiviti'] ?>" method="POST">

                <!-- Input untuk Nama Aktiviti -->
                <label for="input-nama-aktiviti">Nama Aktiviti</label>
                <div class="input-box">
                    <input id="input-nama-aktiviti" type='text' name='nama_aktiviti' value="<?= $m['nama_aktiviti'] ?>"
                        required><br>
                </div>

                <!-- Input untuk Tarikh Aktiviti -->
                <label for="input-tarikh">Tarikh Aktiviti</label>
                <div class="input-box tarikh_aktiviti">
                    <input id="input-tarikh" type='date' name='tarikh_aktiviti' min='<?= date("Y-m-d") ?>'
                        value="<?= $m['tarikh_aktiviti'] ?>" required><br>
                </div>

                <!-- Input untuk Masa Mula Aktiviti -->
                <div class="masa-box">
                    <label for="input-masa-mula">Masa Mula</label>
                    <div class="input-box masa_mula">
                        <input id="input-masa-mula" type='time' name='masa_mula'
                            value="<?php echo date('H:i', strtotime($m['masa_mula'])); ?>" required><br>
                    </div>
                </div>

                <!-- Input untuk Masa Tamat Aktiviti -->
                <div class="masa-box">
                    <label for="input-masa-tamat">Masa Tamat</label>
                    <div class="input-box masa_tamat">
                        <input id="input-masa-tamat" type='time' name='masa_tamat'
                            value="<?php echo date('H:i', strtotime($m['masa_tamat'])); ?>" required><br>
                    </div>
                </div>

                <!-- Butang untuk menghantar borang -->
                <div class="kemaskini-container">
                    <button class="kemaskiniBtn" onclick="sendForm(<?= $m['IDaktiviti'] ?>)"
                        type="submit">Kemaskini</button>
                </div>
            </form>
        </div>
    </div>
</main>

<footer class="bottomed-footer">
    <div class="footer-container">
        <p class="copyright">Hakcipta &copy; 2023-2024: SKKPK SMK Bandar Tasik Puteri</p>
    </div>
</footer>

<!-- Skrip untuk fungsi mesra pengguna buta warna -->
<script src="scripts\colorblind.js" defer></script>

<script>
    // Fungsi untuk menghantar data ke aktiviti-kemaskini-proses.php menggunakan XMLHttpRequest
    function sendForm(IDaktiviti) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "aktiviti-kemaskini-proses.php?IDaktiviti=" + IDaktiviti, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Jika berjaya, kemaskini URL dengan parameter notifikasi kejayaan dan alihkan ke senarai-aktiviti.php
                var urlParams = new URLSearchParams(window.location.search);
                urlParams.set('notificationType', 'success');
                urlParams.set('notificationMessage', 'Aktiviti berjaya dikemaskini!');
                window.location.href = "senarai-aktiviti.php?" + urlParams.toString();
            } else {
                // Jika gagal, kemaskini URL dengan parameter notifikasi ralat dan alihkan ke senarai-aktiviti.php
                var urlParams = new URLSearchParams(window.location.search);
                urlParams.set('notificationType', 'error');
                urlParams.set('notificationMessage', 'Ralat! Aktiviti gagal dikemaskini.');
                window.location.href = "senarai-aktiviti.php?" + urlParams.toString();
            }
        };
        xhr.onerror = function () {
            alert("Ralat berlaku. Sila cuba lagi."); // Papar mesej ralat
        };
        xhr.send();
    }
</script>