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

<div class="wrapper_kemaskini">
    <h1>Kemaskini Aktiviti</h1>

    <form action="aktiviti-kemaskini-proses.php?IDaktiviti=<?= $m['IDaktiviti'] ?>" method="POST">

        <div class="input-box">
            <input type='text' name='nama_aktiviti' value="<?= $m['nama_aktiviti'] ?>" required><br>
        </div>

        <div class="input-box">
            <input type='date' name='tarikh_aktiviti' min='<?= date("Y-m-d") ?>' value="<?= $m['tarikh_aktiviti'] ?>"
                required><br>
        </div>

        <div class="input-box">
            <input type='time' name='masa_mula' value="<?php echo date('H:i', strtotime($m['masa_mula'])); ?>"
                required><br>
        </div>

        <div class="input-box">
            <input type='time' name='masa_tamat' value="<?php echo date('H:i', strtotime($m['masa_tamat'])); ?>" required><br>
        </div>

        <div class="kemaskini-container">
            <button class="kemaskiniBtn" type="submit">Kemaskini</button>
        </div>
    </form>

</div>