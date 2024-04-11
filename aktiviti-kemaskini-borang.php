<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, kawalan-admin.php dan connection.php
include("header.php");
include("kawalan-admin.php");
include("connection.php");

# Menyemak jika data GET wujud. Jika tidak, buka fail senarai-aktiviti.php
if (empty($_GET)) {
    die("<script>window.location.href='senarai-aktiviti.php';</script>");
}

# Mendapatkan maklumat aktiviti dari pangkalan data
$arahan_sql_pilihan = "select * from aktiviti where IDaktiviti='" . $_GET['IDaktiviti'] . "' ";

# Laksana arahan mendapatkan maklumat
$laksana_arahan = mysqli_query($condb, $arahan_sql_pilihan);
$m = mysqli_fetch_array($laksana_arahan);
?>
<main>

    <div class="card wrapper_kemaskini">
        <h1>Kemaskini Aktiviti</h1>

        <form action="aktiviti-kemaskini-proses.php?IDaktiviti=<?= $m['IDaktiviti'] ?>" method="POST">

            <label for="input-nama-aktiviti">Nama Aktiviti</label>
            <div class="input-box">
                <input id="input-nama-aktiviti" type='text' name='nama_aktiviti' value="<?= $m['nama_aktiviti'] ?>" required><br>
            </div>

            <label for="input-tarikh">Tarikh Aktiviti</label>
            <div class="input-box tarikh_aktiviti">
                <input id="input-tarikh" type='date' name='tarikh_aktiviti' min='<?= date("Y-m-d") ?>' value="<?= $m['tarikh_aktiviti'] ?>" required><br>
            </div>

            <div class="masa-box">
                <label for="input-masa-mula">Masa Mula</label>
                <div class="input-box masa_mula">
                    <input id="input-masa-mula" type='time' name='masa_mula' value="<?php echo date('H:i', strtotime($m['masa_mula'])); ?>" required><br>
                </div>
            </div>

            <div class="masa-box">
                <label for="input-masa-tamat">Masa Tamat</label>
                <div class="input-box masa_tamat">
                    <input id="input-masa-tamat" type='time' name='masa_tamat' value="<?php echo date('H:i', strtotime($m['masa_tamat'])); ?>" required><br>
                </div>
            </div>

            <div class="kemaskini-container">
                <button class="kemaskiniBtn" onclick="sendForm(<?= $m['IDaktiviti'] ?>)" type="submit">Kemaskini</button>
            </div>
        </form>

    </div>
</main>
<script>
    // Fungsi hantar data ke aktiviti-kemaskini-proses.php
    function sendForm(IDaktiviti) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "aktiviti-kemaskini-proses.php?IDaktiviti=" + IDaktiviti, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Set the success notification message in sessionStorage
                sessionStorage.setItem('notificationType', '<?php echo isset($_SESSION['notificationType']) ? $_SESSION['notificationType'] : '' ?>');
                sessionStorage.setItem('notificationMessage', '<?php echo isset($_SESSION['notificationMessage']) ? $_SESSION['notificationMessage'] : '' ?>');
                // Redirect to the listing page
                window.location.href = "senarai-aktiviti.php";
            } else {
                // Set the error notification message in sessionStorage
                sessionStorage.setItem('notificationType', '<?php echo isset($_SESSION['notificationType']) ? $_SESSION['notificationType'] : '' ?>');
                sessionStorage.setItem('notificationMessage', '<?php echo isset($_SESSION['notificationMessage']) ? $_SESSION['notificationMessage'] : '' ?>');
                // Redirect to the listing page
                window.location.href = "senarai-aktiviti.php";
            }
        };
        xhr.onerror = function() {
            alert("An error occurred. Please try again."); // Show error message
        };
        xhr.send();
    }
</script>