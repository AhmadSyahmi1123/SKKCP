<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header, fail kawalan-admin.php dan connection.php
include ("header.php");
include ("kawalan-admin.php");
include ("connection.php");

# Menyemak kewujudan data GET. Jika data GET empty, buka fail senarai-ahli
if (empty($_GET)) {
    die("<script>window.location.href='senarai-ahli.php';</script>");
}
?>

<div id="filter-overlay"></div>
<main>
    <div class="wrapper_kemaskini card">
        <div class="kemaskini-borang">
            <h1>Kemaskini Ahli Baru</h1>
            <form class="borang-kemaskini-ahli" action="ahli-kemaskini-proses.php?nokp_lama=<?= $_GET['nokp'] ?>"
                method='POST'>

                <label for="input-nama">Nama</label>
                <div class="input-box">
                    <input id="input-nama" type='text' name='nama' value='<?= $_GET['nama'] ?>' required> <br>
                </div>

                <label for="input-nokp">No. Kad Pengenalan</label>
                <div class="input-box">
                    <input id="input-nokp" type='text' name='nokp' value='<?= $_GET['nokp'] ?>' required> <br>
                </div>

                <label for="input-katalaluan">Katalaluan</label>
                <div class="input-box">
                    <input id="input-katalaluan" type='text' name='katalaluan' value='<?= $_GET['katalaluan'] ?>'
                        required>
                    <br>
                </div>

                <div class="options-container">
                    <div class="select-tahap-box-container">
                        <label for="input-tahap">Tahap</label>
                        <div id="input-tahap" class="select-tahap-box select-aktiviti-container">
                            <select name='tahap' id="select-box-tahap" class="select-tahap">
                                <option value="ADMIN">ADMIN</option>
                                <option value="BIASA">BIASA</option>
                            </select>
                        </div>
                    </div>

                    <div class="select-kelas-box-container">
                        <label for="input-kelas">Kelas</label>
                        <div id="input-kelas" class="select-kelas-box select-aktiviti-container">
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
                    </div>
                </div>
        </div>

        <div class="kemaskini-container">
            <button class="kemaskiniBtn" type="submit">Kemaskini</button>
        </div>

        </form>
    </div>

    <!-- fungsi mesra pengguna buta warna -->
    <script src="scripts\colorblind.js" defer></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="scripts\select-box-update-ahli.js" defer></script>
</main>

<footer>
    <div class="footer-container">
        <p class="copyright">Hakcipta &copy; 2023-2024: SKKPK SMK Bandar Tasik
            Puteri</p>
    </div>
</footer>