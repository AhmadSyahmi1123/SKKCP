<?php
include ("connection.php");

if (isset($_POST['nama'])) {
    $IDaktiviti = $_POST['IDaktiviti'];
    $nama = mysqli_real_escape_string($condb, $_POST['nama']);
    $arahan_papar = "SELECT *, ahli.nokp
                        FROM ahli
                        LEFT JOIN kelas
                        ON ahli.IDkelas = kelas.IDkelas
                        LEFT JOIN kehadiran
                        ON ahli.nokp = kehadiran.nokp
                        and IDaktiviti like '%$IDaktiviti%'
                        where ahli.nama like '%$nama%'
                        ORDER BY ahli.nama ASC";

    $laksana = mysqli_query($condb, $arahan_papar);
    $bil = 0;

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
}