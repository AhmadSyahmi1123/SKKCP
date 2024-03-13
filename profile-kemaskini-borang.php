<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header, fail kawalan-admin.php dan connection.php
include("header.php");
include("connection.php");

?>
<main>
    <div class="wrapper_kemaskini card">
        <h1>Kemaskini Ahli Baru</h1>
        <form class="borang-kemaskini-ahli" action="profile-kemaskini-proses.php?nokp_lama=<?= $_SESSION['nokp'] ?>"
            method='POST'>

            <label for="input-nama">Nama</label>
            <div class="input-box">
                <input id="input-nama" type='text' name='nama' value='<?= $_SESSION['nama'] ?>' required> <br>
            </div>

            <label for="input-nokp">No. Kad Pengenalan</label>
            <div class="input-box">
                <input id="input-nokp" type='text' name='nokp' value='<?= $_SESSION['nokp'] ?>' required> <br>
            </div>

            <label for="input-katalaluan">Katalaluan</label>
            <div class="input-box">
                <input id="input-katalaluan" type='text' name='katalaluan' value='<?= $_SESSION['katalaluan'] ?>'
                    required>
                <br>
            </div>

            <label for="input-kelas">Kelas</label>
            <div id="input-kelas" class="select-kelas-box select-aktiviti-container">
                <select name='IDkelas' id="select-box-kelas" class="select-kelas">
                    <option value='<?= $_SESSION['IDkelas'] ?>'>
                        <?= $_SESSION['ting'] ?>
                        <?= $_SESSION['nama_kelas'] ?>
                    </option>

                    <?php
                    # Proses memaparkan senarai kelas dalam bentuk dropdown list
                    $arahan_sql_pilih = "select * from kelas";
                    $laksana_arahan_pilih = mysqli_query($condb, $arahan_sql_pilih);
                    while ($m = mysqli_fetch_array($laksana_arahan_pilih)) {
                        if ($m["IDkelas"] != $_SESSION['IDkelas']) {
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
</main>