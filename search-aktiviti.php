<?php
include ("connection.php");

if (isset($_POST['nama_aktiviti'])) {
    $nama_aktiviti = mysqli_real_escape_string($condb, $_POST['nama_aktiviti']);
    $arahan_papar = "SELECT *
                     FROM aktiviti
                     WHERE nama_aktiviti LIKE '%$nama_aktiviti%'";

    $laksana = mysqli_query($condb, $arahan_papar);
    $bil = 0;

    while ($m = mysqli_fetch_array($laksana)) {
        echo "<tr>
            <td>" . $m['nama_aktiviti'] . "</td>
            <td>" . date('d/m/Y', strtotime($m['tarikh_aktiviti'])) . "</td>
            <td>" . date('H:i', strtotime($m['masa_mula'])) . "</td>
            <td>" . date('H:i', strtotime($m['masa_tamat'])) . "</td>
        ";

        # Memaparkan navigasi untuk kemaskini dan hapus data aktiviti
        echo "<td>
                <div class='action-container'>
                    <div class='edit-container'>
                        <button class='editBtn' data-tooltip='Kemaskini'>
                            <a href='aktiviti-kemaskini-borang.php?IDaktiviti=" . $m['IDaktiviti'] . "'><i class='bx bx-edit'></i></a>
                        </button>
                    </div>

                    <div class='delete-container'>
                        <button class='deleteBtn' data-tooltip='Hapus'>
                            <a href='aktiviti-padam-proses.php?IDaktiviti=" . $m['IDaktiviti'] . "' onclick=\"return confirm('Anda pasti anda ingin memadam data ini?')\"><i class='bx bx-trash'></i></a>
                        </button>
                    </div>

                    <div class='hadir-container'>
                        <button class='hadirBtn' data-tooltip='Pengesahan Kehadiran'>
                            <a href='kehadiran-borang.php?IDaktiviti=" . $m['IDaktiviti'] . "'><i class='bx bx-list-check'></i></a>
                        </button>
                    </div>
                </div>
            </td>
        </tr>";
    }
}