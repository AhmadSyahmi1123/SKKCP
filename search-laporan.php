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

    # Laksana arahan mencari data aktiviti
    $laksana = mysqli_query($condb, $arahan_papar);
    $hadir = $tak_hadir = $bil = 0;

    if (mysqli_num_rows($laksana) > 0) {
        # Mengambil data yang ditemui
        while ($m = mysqli_fetch_array($laksana)) {
            # Memaparkan senarai nama dalam jadual
            echo "<tr>
                    <td>" . ++$bil . "</td>
                    <td><div class='profile_img_list_container'><img class='profile_img_list' src='uploads/" . $m['profile_pic'] . "'></div><div class='td-name'>" . $m['nama'] . "</div></td>
                    <td>" . $m['nokp'] . "</td>
                    <td>" . $m['ting'] . " " . $m['nama_kelas'] . "</td>
                    <td align='center' >
                    ";

            if (strlen($m['IDaktiviti']) >= 1) {
                echo "<div class='status-hadir'>Hadir</div>";
            } else {
                echo "<div class='status-tidak-hadir'>Tidak Hadir</div>";
            }

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
    } else {
        echo "<div class='no-data-text-container'>
            <div class='text-area'>Maaf, tiada data untuk dipaparkan...</div>
        </div>";
    }
}