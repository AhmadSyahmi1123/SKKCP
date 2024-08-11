<?php
# Memulakan sesi
session_start();

# Memanggil fail header dan connection.php untuk sambungan pangkalan data
include ("header.php");
include ("connection.php");
?>

<div id="filter-overlay"></div>
<main>
    <div class="wrapper_kemaskini card">

        <h1>Kemaskini Ahli Baru</h1>
        <form class="borang-kemaskini-ahli" action="profile-kemaskini-proses.php?nokp_lama=<?= $_SESSION['nokp'] ?>"
            method='POST' enctype="multipart/form-data">

            <!-- Input untuk Nama Ahli -->
            <label for="input-nama">Nama</label>
            <div class="input-box">
                <input id="input-nama" type='text' name='nama' value='<?= $_SESSION['nama'] ?>' required> <br>
            </div>

            <!-- Input untuk No. Kad Pengenalan -->
            <label for="input-nokp">No. Kad Pengenalan</label>
            <div class="input-box">
                <input id="input-nokp" type='text' name='nokp' value='<?= $_SESSION['nokp'] ?>' required> <br>
            </div>

            <!-- Input untuk Katalaluan -->
            <label for="input-katalaluan">Katalaluan</label>
            <div class="input-box">
                <input id="input-katalaluan" type='text' name='katalaluan' value='<?= $_SESSION['katalaluan'] ?>'
                    required>
                <br>
            </div>

            <!-- Dropdown untuk memilih kelas -->
            <div class="options-container">
                <div class="select-kelas-box-container">
                    <label for="input-kelas">Kelas</label>
                    <div id="input-kelas" class="select-kelas-box select-aktiviti-container">
                        <select name='IDkelas' id="select-box-kelas" class="select-kelas">
                            <!-- Pilihan kelas sedia ada untuk pengguna -->
                            <option value='<?= $_SESSION['IDkelas'] ?>'>
                                <?= $_SESSION['ting'] ?>
                                <?= $_SESSION['nama_kelas'] ?>
                            </option>

                            <?php
                            # Arahan untuk mendapatkan senarai kelas dari pangkalan data
                            $arahan_sql_pilih = "SELECT * FROM kelas";
                            $laksana_arahan_pilih = mysqli_query($condb, $arahan_sql_pilih);

                            # Paparkan pilihan kelas lain dalam dropdown
                            while ($m = mysqli_fetch_array($laksana_arahan_pilih)) {
                                if ($m["IDkelas"] != $_SESSION['IDkelas']) {
                                    echo "<option value='" . $m['IDkelas'] . "'> " . $m['ting'] . " " . $m['nama_kelas'] . " </option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Bahagian untuk mengemaskini gambar profil -->
            <div class="kemaskini_profile_pic_container">
                <div class="edit_profile_pic">
                    <!-- Paparkan gambar profil semasa -->
                    <img id="profile_picture" src="uploads/<?= $_SESSION["profile_pic"] ?>">
                </div>
                <!-- Butang untuk memilih gambar baru -->
                <button data-tooltip="Kemaskini Gambar Profil" class="select_pic_btn">
                    <i class='material-symbols-outlined'>edit</i>
                    <input id="choose_img" type="file" name='profile_pic' accept=".png, .jpg, .jpeg">
                </button>

                <script>
                    // Menukar gambar profil pratonton apabila memilih gambar baru
                    document.getElementById("choose_img").addEventListener("change", function () {
                        let profilePic = document.getElementById("profile_picture");
                        let inputFile = this;

                        if (inputFile.files && inputFile.files[0]) {
                            let reader = new FileReader();

                            reader.onload = function (e) {
                                profilePic.src = e.target.result;
                            };

                            reader.readAsDataURL(inputFile.files[0]);
                        }
                    });
                </script>
            </div>

            <!-- Butang untuk mengemaskini atau membatalkan -->
            <div class="kemaskini-container">
                <button class="kemaskiniBtn" name="submit" type="submit">Kemaskini</button>
                <button class="cancelBtn" type="button" onclick="window.history.back();">Batal</button>
            </div>

        </form>

    </div>

    <!-- Memasukkan skrip untuk menyokong buta warna -->
    <script src="scripts/colorblind.js" defer></script>

    <!-- Memasukkan skrip jQuery dan Select2 untuk kemudahan antaramuka -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="scripts/select-box-update-ahli.js" defer></script>
</main>

<footer class="default-footer">
    <div class="footer-container">
        <p class="copyright">Hakcipta &copy; 2023-2024: SKKPK SMK Bandar Tasik Puteri</p>
    </div>
</footer>