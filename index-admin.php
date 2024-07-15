<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php dan connection.php
include ("header.php");
include ("connection.php");

$nokp = $_SESSION['nokp'];

# Kira bilangan ahli
$sql_ahli = "SELECT * FROM ahli";
$exec_ahli = mysqli_query($condb, $sql_ahli);
$count_ahli = mysqli_num_rows($exec_ahli);

# Kira bilangan aktiviti
$sql_aktiviti = "SELECT * FROM aktiviti";
$exec_aktiviti = mysqli_query($condb, $sql_aktiviti);
$count_aktiviti = mysqli_num_rows($exec_aktiviti);

# Kira bilangan kehadiran ahli
$sql_count = "SELECT COUNT(*) as count FROM kehadiran WHERE nokp = '$nokp'";
$exec_count = mysqli_query($condb, $sql_count);
$row_hadir = mysqli_fetch_assoc($exec_count);
$count_hadir = $row_hadir['count'];

# Kira bilangan tidak hadir
$sql_aktiviti = "SELECT COUNT(*) as count FROM aktiviti";
$exec_aktiviti = mysqli_query($condb, $sql_aktiviti);
$row_aktiviti = mysqli_fetch_assoc($exec_aktiviti);
$count_aktiviti = $row_aktiviti['count'];

$count_tidak_hadir = $count_aktiviti - $count_hadir;

?>
<div class="page-header">Dashboard</div>
<main>
    <div class="dashboard-container">
        <div class="card ahli-count-container">
            <div class="count-text-container">
                <div class="count-label">Bilangan Ahli</div>
                <div class="icon-ahli-container">
                    <span class="material-symbols-outlined">groups</span>
                </div>
            </div>
            <div class="count-container">
                <div class="count-text">
                    <?php echo $count_ahli ?>
                </div>
            </div>
        </div>
        <div class="card aktiviti-count-container">
            <div class="count-text-container">
                <div class="count-label">Bilangan Aktiviti</div>
                <div class="icon-ahli-container">
                    <span class="material-symbols-outlined">assignment</span>
                </div>
            </div>
            <div class="count-container">
                <div class="count-text">
                    <?php echo $count_aktiviti ?>
                </div>
            </div>
        </div>
        <div class="card ahli-count-container">
            <div class="count-text-container">
                <div class="count-label">Hadir</div>
                <div class="icon-ahli-container">
                    <span class="material-symbols-outlined">check </span>
                </div>
            </div>
            <div class="count-container">
                <div class="count-text">
                    <?php echo $count_hadir ?>
                </div>
            </div>
        </div>
        <div class="card aktiviti-count-container">
            <div class="count-text-container">
                <div class="count-label">Tidak Hadir</div>
                <div class="icon-ahli-container">
                    <span class="material-symbols-outlined">close</span>
                </div>
            </div>
            <div class="count-container">
                <div class="count-text">
                    <?php echo $count_tidak_hadir ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card leaderboard-container">
        <div class="leaderboard-title count-label">
            <div class="leaderboard-icon">
                <span class="material-symbols-outlined">leaderboard</span>
            </div>
            Carta Pendahulu
        </div>
        <div class="card-header-container">
            <div class="input-carian-container">
                <div class="input-carian">
                    <input type='text' id="searchNama" name='nama' placeholder='Carian Nama Ahli'>
                </div>
            </div>
            <div class="font-size-button">
                <button class="increase-size-btn" onclick="ubahsaiz(1)" data-tooltip="Tambah Saiz Tulisan"><span
                        class="material-symbols-outlined">text_increase</span></button>
                <button class="decrease-size-btn" onclick="ubahsaiz(-1)" data-tooltip="Tolak Saiz Tulisan"><span
                        class="material-symbols-outlined">text_decrease</span></button>
                <button class="reset-font-size" onclick="ubahsaiz(2)">Reset Size</button>
                <button class="print-btn" onclick="printPage()">Cetak</button>
            </div>
        </div>
        <div class="leaderboard">
            <div class="scrollable-table" id="print-area">
                <table class="table" id="saiz">
                    <thead>
                        <tr>
                            <th>Bil</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Mata</th>
                        </tr>
                    </thead>
                    <tbody id="leaderboardBody">
                        <?php
                        # Arahan query untuk mencari senarai aktiviti
                        $arahan_papar = "SELECT ahli.nama, ahli.mata, ahli.profile_pic, kelas.ting, kelas.nama_kelas
                                    FROM ahli
                                    JOIN kelas ON ahli.IDkelas = kelas.IDkelas
                                    ORDER BY mata DESC
                                    ";

                        # Laksana arahan mencari data aktiviti
                        $laksana = mysqli_query($condb, $arahan_papar);
                        $bil = 0;

                        # Mengambil data yang ditemui
                        while ($m = mysqli_fetch_array($laksana)) {
                            # Memaparkan senarai nama dalam jadual
                            echo "<tr>
                                <td>" . ++$bil . "</td>
                                <td><div class='profile_img_list_container'><img class='profile_img_list' src='uploads/" . $m['profile_pic'] . "'></div><div class='td-name'>" . $m['nama'] . "</div></td>
                                <td>" . $m['ting'] . " " . $m['nama_kelas'] . "</td>
                                <td>" . $m['mata'] . "</td>
                                ";
                            echo "</td></tr>";
                        }
                        echo "</table>"; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Proses papar notifikasi apabila kemaskini data -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="scripts\toast.js"></script>

<!-- fungsi mengubah saiz tulisan bagi kemudahan pengguna dan mencetak jadual-->
<script src="scripts\butang-saiz.js" defer></script>
<script src="scripts\print-page.js" defer></script>

<!-- fungsi untuk mencari nama ahli dalam carta pendahulu  -->
<script>
    document.getElementById('searchNama').addEventListener('input', function () {
        const searchValue = this.value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'search-leaderboard.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            if (this.status === 200) {
                document.getElementById('leaderboardBody').innerHTML = this.responseText;
            }
        }

        xhr.send('nama=' + encodeURIComponent(searchValue));
    });
</script>