<?php
include ("connection.php");

if (isset($_POST['nama'])) {
    $nama = mysqli_real_escape_string($condb, $_POST['nama']);
    $arahan_papar = "SELECT *
                     FROM ahli, kelas
                     WHERE ahli.IDkelas = kelas.IDkelas
                     AND ahli.nama LIKE '%$nama%'";

    $laksana = mysqli_query($condb, $arahan_papar);
    $bil = 0;

    while ($m = mysqli_fetch_array($laksana)) {
        # Umpukkan data kepda tatasusunan bagi tujuan kemaskini ahli
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

        # Memaparkan senarai nama dalam jadual
        echo "<tr>
        <td><div class='profile_img_list_container'><img class='profile_img_list' src='uploads/" . $m['profile_pic'] . "'></div><div class='td-name'>" . $m['nama'] . "</div></td>
        <td>" . $m['nokp'] . "</td>
        <td>" . $m['ting'] . " " . $m['nama_kelas'] . "</td>
        <td>" . $m['katalaluan'] . "</td>
        <td>" . $m['tahap'] . "</td>
        <td>" . $m['mata'] . "</td>
    ";


        # Memaparkan navigasi untuk kemaskini dan hapus data ahli
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
}