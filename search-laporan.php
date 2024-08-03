<?php
# Memanggil fail connection.php untuk sambungan ke pangkalan data
include ("connection.php");

# Memeriksa jika borang dihantar dan nama tidak kosong
if (isset($_POST['nama'])) {
    # Mendapatkan IDaktiviti dan nama dari borang
    $IDaktiviti = $_POST['IDaktiviti'];
    $nama = mysqli_real_escape_string($condb, $_POST['nama']);

    # Arahan SQL untuk mendapatkan maklumat ahli bersama kehadiran mereka berdasarkan nama dan IDaktiviti
    $arahan_papar = "SELECT *, ahli.nokp
                        FROM ahli
                        LEFT JOIN kelas
                        ON ahli.IDkelas = kelas.IDkelas
                        LEFT JOIN kehadiran
                        ON ahli.nokp = kehadiran.nokp
                        AND IDaktiviti LIKE '%$IDaktiviti%'
                        WHERE ahli.nama LIKE '%$nama%'
                        ORDER BY ahli.nama ASC";

    # Melaksanakan arahan SQL
    $laksana = mysqli_query($condb, $arahan_papar);
    $bil = 0;

    # Mengambil data dari hasil query dan memaparkannya dalam jadual
    while ($m = mysqli_fetch_array($laksana)) {
        # Memaparkan nombor urutan ahli
        echo "<tr>
        <td>" . ++$bil . "</td>
        <td><div class='profile_img_list_container'><img class='profile_img_list' src='uploads/" . $m['profile_pic'] . "'></div><div class='td-name'>" . $m['nama'] . "</div></td>
        <td>" . $m['nokp'] . "</td>
        <td>" . $m['ting'] . " " . $m['nama_kelas'] . "</td>
        <td align='center'>";

        if (strlen($m['IDaktiviti']) >= 1) {
            # Memaparkan status "Hadir" jika ahli mempunyai IDaktiviti
            echo "<div class='status-hadir'>Hadir</div>";
        } else {
            # Memaparkan status "Tidak Hadir" jika ahli tidak mempunyai IDaktiviti
            echo "<div class='status-tidak-hadir'>Tidak Hadir</div>";
        }

        # Menyediakan butang untuk tambah/tolak mata
        echo "<td>
        <div class='action-container'>
            <div class='edit-mata-container'>
                <button class='editMataBtn open-update-point' data-tooltip='Tambah/Tolak Mata' data-nokp='" . $m['nokp'] . "'>
                    <i class='material-symbols-outlined'>stars</i>
                </button>
            </div>
        </div>
    </td>";

        echo "</td></tr>";
    }
    echo "</table>";
}
?>