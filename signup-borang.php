<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php dan connection.php
include ("header.php");
include ("connection.php");
?>

<div class="wrapper-container">
    <div class="card wrapper">
        <!-- Tajuk antaramuka -->
        <h1>Pendaftaran Ahli Baru</h1>
        <div class="borang-signup">
            <!-- Borang Pendaftaran Ahli Baru -->
            <form action="signup-proses.php" method="POST" enctype="multipart/form-data">

                <div class="borang-input">
                    <div class="input-box">
                        <input type="text" name="nama" placeholder="Nama Ahli" required>
                        <i class='bx bxs-user'></i>
                    </div>

                    <div class="input-box">
                        <input type="text" name="nokp" placeholder="No. Kad Pengenalan" required>
                        <i class='bx bx-hash'></i>
                    </div>

                    <div class="select-container">
                        <select name="IDkelas" id="select-box-kelas" class="select-kelas">
                            <option selected disabled value>Sila Pilih Kelas</option>
                            <?php
                            # Proses memaparkan senarai kelas dalam bentuk drodown list
                            $arahan_sql_pilih = "select* from kelas";
                            $laksana_arahan_pilih = mysqli_query($condb, $arahan_sql_pilih);
                            while ($m = mysqli_fetch_array($laksana_arahan_pilih)) {
                                echo "<option value='" . $m['IDkelas'] . "'>" . $m['ting'] . " " . $m['nama_kelas'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="input-box">
                        <input type="password" name='katalaluan' placeholder="Katalaluan" required>
                        <i class="fas fa-eye-slash password-toggle"></i>
                    </div>

                    <div class="choose-file-btn">
                        <input type="file" id="choose_img" name='profile_pic' accept=".png, .jpg, .jpeg">
                    </div>
                </div>
                <input class="btn" type='submit' value='Daftar'>
            </form>

            <div class="signup_profile_pic_container">
                <div class="edit_profile_pic">
                    <img class="signup_pp" src="uploads/default-avatar.png">
                </div>

                <script>
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

<script src="scripts\password-visibility-toggle.js" defer></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="scripts\select-box-signup.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="scripts\toast.js"></script>