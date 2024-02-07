<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php dan connection.php
include("header.php");
include("connection.php");
?>

<div class="wrapper">
    <!-- Borang Pendaftaran Ahli Baru -->
    <form action="signup-proses.php" method="POST">

        <!-- Tajuk antaramuka -->
        <h1>Pendaftaran Ahli Baru</h1>

        <div class="input-box">
            <input type="text" name="nama" placeholder="Nama Ahli" required>
            <i class='bx bxs-user'></i>
        </div>

        <div class="input-box">
            <input type="text" name="nokp" placeholder="No. Kad Pengenalan" required>
            <i class='bx bx-hash'></i>
        </div>

        <div class="select-container">
            <select name="IDkelas" class="select-box">
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
            <div class="icon-container">
                <i class='bx bx-chevron-down'></i>
            </div>
        </div>

        <div class="input-box">
            <input type="password" name='katalaluan' placeholder="Katalaluan" required>
            <i class='bx bxs-lock-alt'></i>
        </div>

        <input class="btn" type='submit' value='Daftar'>
    </form>
</div>