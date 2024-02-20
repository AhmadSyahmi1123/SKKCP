<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header, fail kawalan-admin.php dan connection.php
include("header.php");
include("kawalan-admin.php");
include("connection.php");

# Menyemak kewujudan data GET. Jika data GET empty, buka fail senarai-ahli
if (empty($_GET)) {
    die("<script>window.location.href='senarai-ahli.php';</script>");
}
?>

<div class="wrapper_kemaskini">
    <h1>Kemaskini Ahli Baru</h1>
    <form action="ahli-kemaskini-proses.php?nokp_lama=<?= $_GET['nokp'] ?>" method='POST'>
        <div class="input-box">
            <input type='text' name='nama' value='<?= $_GET['nama'] ?>' required> <br>
        </div>

        <div class="input-box">
            <input type='text' name='nokp' value='<?= $_GET['nokp'] ?>' required> <br>
        </div>

        <div class="input-box">
            <input type='text' name='katalaluan' value='<?= $_GET['katalaluan'] ?>' required> <br>
        </div>

        <div class="select-aktiviti-container">
            <select name='tahap' id="select-box-tahap" class="select-tahap">
                <option value='<?= $_GET['tahap'] ?>'>
                    <?= $_GET['tahap'] ?>
                </option>

                <?php
                # Proses memaparkan senarai tahap dalam bentuk dropdown list
                $arahan_sql_tahap = "select tahap from ahli group by tahap order by tahap";
                $laksana_arahan_tahap = mysqli_query($condb, $arahan_sql_tahap);
                while ($n = mysqli_fetch_array($laksana_arahan_tahap)) {
                    if ($n["tahap"] != $_GET['tahap']) {
                        echo "<option value='" . $n['tahap'] . "'></option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="select-aktiviti-container">
            <select name='IDkelas' id="select-box-kelas" class="select-kelas">
                <option value='<?= $_GET['IDkelas'] ?>'>
                    <?= $_GET['ting'] ?>
                    <?= $_GET['nama_kelas'] ?>
                </option>

                <?php
                # Proses memaparkan senarai kelas dalam bentuk dropdown list
                $arahan_sql_pilih = "select * from kelas";
                $laksana_arahan_pilih = mysqli_query($condb, $arahan_sql_pilih);
                while ($m = mysqli_fetch_array($laksana_arahan_pilih)) {
                    if ($m["IDkelas"] != $_GET['IDkelas']) {
                        echo "<option value='" . $m['IDkelas'] . "'> " . $m['ting'] . " " . $m['nama_kelas'] . " </option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="kemaskini-container">
            <button class="kemaskiniBtn" type="submit">Kemaskini</button>
        </div>

    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="scripts\select-box-update-ahli.js" defer></script>