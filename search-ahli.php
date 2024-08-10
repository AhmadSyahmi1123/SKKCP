<?php
# Memanggil fail connection.php untuk sambungan ke pangkalan data
include ("connection.php");

# Memeriksa jika borang dihantar dan nama tidak kosong
if (isset($_POST['nama'])) {
    # Melarikan input nama untuk mengelakkan serangan SQL injection
    $nama = mysqli_real_escape_string($condb, $_POST['nama']);

    # Arahan SQL untuk mendapatkan maklumat ahli yang namanya sepadan dengan input nama
    $arahan_papar = "SELECT *
                     FROM ahli, kelas
                     WHERE ahli.IDkelas = kelas.IDkelas
                     AND ahli.nama LIKE '%$nama%'
                     ORDER BY ahli.nama ASC";

    # Melaksanakan arahan SQL
    $laksana = mysqli_query($condb, $arahan_papar);

    if (mysqli_num_rows($laksana) > 0) {
        # Mengambil setiap baris data yang ditemui
        while ($m = mysqli_fetch_array($laksana)) {

            # Menyimpan data dalam tatasusunan untuk tujuan kemaskini ahli
            $data_get = array(
                'nama' => $m['nama'],
                'profile_pic' => $m['profile_pic'],
                'nokp' => $m['nokp'],
                'katalaluan' => $m['katalaluan'],
                'tahap' => $m['tahap'],
                'IDkelas' => $m['IDkelas'],
                'ting' => $m['ting'],
                'nama_kelas' => $m['nama_kelas'],
                'mata' => $m['mata']
            );

            # Mengira jumlah kehadiran ahli
            $nokp = $m['nokp'];
            $sql_count = "SELECT COUNT(*) as count FROM kehadiran WHERE nokp = '$nokp'";
            $exec_count = mysqli_query($condb, $sql_count);
            $row_hadir = mysqli_fetch_assoc($exec_count);
            $count_hadir = $row_hadir['count'];

            # Mengira jumlah aktiviti
            $sql_aktiviti = "SELECT COUNT(*) as count FROM aktiviti";
            $exec_aktiviti = mysqli_query($condb, $sql_aktiviti);
            $row_aktiviti = mysqli_fetch_assoc($exec_aktiviti);
            $count_aktiviti = $row_aktiviti['count'];

            # Memaparkan data dalam jadual
            echo "<tr>
                    <td><div class='profile_img_list_container'><img class='profile_img_list' src='uploads/" . $m['profile_pic'] . "'></div><div class='td-name'>" . $m['nama'] . "</div></td>
                    <td>" . $m['nokp'] . "</td>
                    <td>" . $m['ting'] . " " . $m['nama_kelas'] . "</td>
                    <td>" . $m['katalaluan'] . "</td>
                    <td>" . $m['tahap'] . "</td>
                    <td>" . $m['mata'] . "</td>
                    <td>$count_hadir/$count_aktiviti</td>
                ";

            # Memaparkan butang kemaskini dan hapus data ahli
            echo "<td>
                    <div class='action-container'>
                        <div class='edit-container'>
                            <button class='editBtn' data-tooltip='Kemaskini'>
                                <a href='ahli-kemaskini-borang.php?" . http_build_query($data_get) . "'><i class='bx bx-edit'></i></a>
                            </button>
                        </div>

                        <div class='delete-container'>
                            <button class='deleteBtn' data-tooltip='Hapus'>
                                <a href='ahli-padam-proses.php?nokp=" . $m['nokp'] . "' onclick=\"return confirm('Anda pasti anda ingin memadam data ini?')\">
                                    <i class='bx bx-trash'></i>
                                </a>                        
                            </button>
                        </div>
                    </div>
                </td>
            </tr>";
        }
    } else {
        # Jika tiada data untuk dipaparkan, papar teks "Maaf, tiada data untuk dipaparkan"
        echo "<div class='no-data-text-container'>
            <div class='text-area'>Maaf, data tidak wujud...</div>
        </div>";
    }
}
