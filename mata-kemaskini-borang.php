<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, kawalan-admin.php dan connection.php
include ("header.php");
include ("kawalan-admin.php");
include ("connection.php");

# Menyemak jika data GET wujud. Jika tidak, buka fail senarai-aktiviti.php
if (empty($_GET)) {
    die("<script>window.location.href='senarai-aktiviti.php';</script>");
}

# Mendapatkan maklumat ahli dari pangkalan data berdasarkan nokp yang diberikan
$arahan_sql_pilihan = "SELECT * FROM ahli WHERE nokp='" . $_GET['nokp'] . "' ";

# Laksanakan arahan mendapatkan maklumat
$laksana_arahan = mysqli_query($condb, $arahan_sql_pilihan);
$m = mysqli_fetch_array($laksana_arahan);
?>

<main>
    <div class="card wrapper_mata">
        <h1>Tambah Mata Ahli</h1>

        <!-- Borang untuk menambah mata ahli -->
        <form action="mata-kemaskini-proses.php?nokp=<?= $m['nokp'] ?>" method="POST">

            <div class="input-box">
                <input type='number' name='mata' value="0" required><br>
            </div>

            <div class="tambah-mata-container">
                <button class="tambahMataBtn" type="submit">Tambah</button>
            </div>
        </form>
    </div>
</main>