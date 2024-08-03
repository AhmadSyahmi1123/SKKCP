<?php
# Memulakan sesi pengguna
session_start();

# Memanggil fail header.php dan connection.php
include ("header.php");
include ("connection.php");
?>

<div id="filter-overlay"></div>
<div class="wrapper-container">
    <div class="card wrapper signup">
        <!-- Tajuk antaramuka -->
        <h1>Pendaftaran Ahli Baru</h1>
        <div class="borang-signup">
            <!-- Borang Pendaftaran Ahli Baru -->
            <form action="signup-proses.php" method="POST" enctype="multipart/form-data">

                <div class="borang-input">
                    <!-- Input untuk nama ahli -->
                    <label for="input-nama">Nama Ahli</label>
                    <div class="input-box">
                        <input type="text" name="nama" placeholder="Nama Ahli" required>
                        <i class='bx bxs-user'></i>
                    </div>

                    <!-- Input untuk nombor kad pengenalan -->
                    <label for="input-nama">Nombor Kad Pengenalan</label>
                    <div class="input-box">
                        <input type="text" name="nokp" placeholder="No. Kad Pengenalan" required>
                        <i class='bx bx-hash'></i>
                    </div>

                    <!-- Pilihan dropdown untuk kelas -->
                    <label for="input-nama">Kelas</label>
                    <div class="select-container">
                        <select name="IDkelas" id="select-box-kelas" class="select-kelas">
                            <option selected disabled value>Sila Pilih Kelas</option>
                            <?php
                            # Proses memaparkan senarai kelas dalam bentuk dropdown list
                            $arahan_sql_pilih = "select* from kelas";
                            $laksana_arahan_pilih = mysqli_query($condb, $arahan_sql_pilih);
                            while ($m = mysqli_fetch_array($laksana_arahan_pilih)) {
                                echo "<option value='" . $m['IDkelas'] . "'>" . $m['ting'] . " " . $m['nama_kelas'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Input untuk katalaluan -->
                    <label for="input-nama">Katalaluan</label>
                    <div class="input-box">
                        <input type="password" name='katalaluan' placeholder="Katalaluan" required>
                        <i class="fas fa-eye password-toggle"></i>
                    </div>

                    <!-- Input untuk gambar profil -->
                    <label for="input-nama">Gambar Profil</label>
                    <div class="choose-file-btn">
                        <input type="file" id="choose_img" name='profile_pic' accept=".png, .jpg, .jpeg">
                    </div>
                </div>
                <!-- Butang untuk menghantar borang pendaftaran -->
                <input class="btn" type='submit' value='Daftar'>
            </form>

            <!-- Paparan gambar profil yang dipilih ahli -->
            <div class="signup_profile_pic_container">
                <div class="edit_profile_pic">
                    <img class="signup_pp" src="uploads/default-avatar.png">
                </div>

                <script>
                    // Kemaskini gambar pengguna yang dipaparkan mengikut pilihan pengguna
                    document.getElementById("choose_img").addEventListener("change", function () {
                        let profilePic = document.querySelector(".signup_pp");
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
        </div>
    </div>
</div>

<!-- Kaki laman (footer) -->
<footer class="default-footer">
    <div class="footer-container">
        <p class="copyright">Hakcipta &copy; 2024-2025: SKKPK SMK Bandar Tasik Puteri</p>
    </div>
</footer>

<!-- Skrip mesra pengguna buta warna -->
<script src="scripts\colorblind.js" defer></script>

<!-- Skrip toggle visibility katalaluan -->
<script src="scripts\password-visibility-toggle.js" defer></script>

<!-- Skrip dropdown list -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="scripts\select-box-signup.js" defer></script>

<!-- Skrip paparan notifikasi maklumbalas -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="scripts\toast.js"></script>