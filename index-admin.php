<?php
# Memulakan sesi untuk menyimpan data pengguna
session_start();

# Memanggil fail header.php dan connection.php untuk penyambungan dan header
include ("header.php");
include ("connection.php");

# Mendapatkan nombor kad pengenalan dari sesi
$nokp = $_SESSION['nokp'];

# Kira bilangan ahli dalam pangkalan data
$sql_ahli = "SELECT * FROM ahli";
$exec_ahli = mysqli_query($condb, $sql_ahli);
$count_ahli = mysqli_num_rows($exec_ahli);

# Kira bilangan aktiviti dalam pangkalan data
$sql_aktiviti = "SELECT * FROM aktiviti";
$exec_aktiviti = mysqli_query($condb, $sql_aktiviti);
$count_aktiviti = mysqli_num_rows($exec_aktiviti);

# Kira bilangan kehadiran untuk pengguna semasa
$sql_count = "SELECT COUNT(*) as count FROM kehadiran WHERE nokp = '$nokp'";
$exec_count = mysqli_query($condb, $sql_count);
$row_hadir = mysqli_fetch_assoc($exec_count);
$count_hadir = $row_hadir['count'];

# Kira bilangan aktiviti yang belum dihadiri
$sql_aktiviti = "SELECT COUNT(*) as count FROM aktiviti";
$exec_aktiviti = mysqli_query($condb, $sql_aktiviti);
$row_aktiviti = mysqli_fetch_assoc($exec_aktiviti);
$count_aktiviti = $row_aktiviti['count'];

$count_tidak_hadir = $count_aktiviti - $count_hadir;

?>
<div id="filter-overlay"></div>
<div class="header-container">
    <div class="page-header">Dashboard</div>
    <div class="colorblind-container">
        <button class="reset-colorblind-btn" onclick="resetFilter()" data-tooltip="Reset Warna"><i
                class='bx bx-reset'></i></button>
        <button class="colorblind-btn" onclick="toggleFilter()" data-tooltip="Buta Warna"><span
                class="material-symbols-outlined">symptoms</span></button>
    </div>
</div>
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
                        # Arahan query untuk mendapatkan senarai ahli
                        $arahan_papar = "SELECT ahli.nama, ahli.mata, ahli.profile_pic, kelas.ting, kelas.nama_kelas
                                    FROM ahli
                                    JOIN kelas ON ahli.IDkelas = kelas.IDkelas
                                    ORDER BY mata DESC
                                    ";

                        # Laksanakan arahan untuk mendapatkan data
                        $laksana = mysqli_query($condb, $arahan_papar);
                        $bil = 0;

                        # Mengambil dan memaparkan data ahli dalam jadual
                        while ($m = mysqli_fetch_array($laksana)) {
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

<footer class="default-footer">
    <div class="footer-container">
        <p class="copyright">Hakcipta &copy; 2024-2025: SKKPK SMK Bandar Tasik Puteri</p>
    </div>
</footer>

<!-- Fungsi data tooltip (petunjuk bagi pengguna bagi butang yang hanya mempunyai ikon) -->
<script src="scripts/datatooltip.js" defer></script>

<!-- Fungsi mesra pengguna buta warna -->
<script src="scripts/colorblind.js" defer></script>

<!-- Proses papar notifikasi apabila kemaskini data -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="scripts/toast.js"></script>

<!-- Fungsi mengubah saiz tulisan bagi kemudahan pengguna dan mencetak jadual -->
<script src="scripts/butang-saiz.js" defer></script>
<script src="scripts/print-page.js" defer></script>

<!-- Fungsi untuk mencari nama ahli dalam carta pendahulu -->
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