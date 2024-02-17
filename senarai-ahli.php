<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, connection.php dan kawalan-admin.php
include("header.php");
include("connection.php");
include("kawalan-admin.php");
?>

<!-- Header bagi jadual untuk memaparkan senarai ahli -->
<h3 align='center'>Senarai Ahli</h3>

<div class="searchNupload-container">
    <div class="input-carian-container">
        <form action='' method="POST">
            <div class="input-carian">
                <input type='text' name='nama' placeholder='Carian Nama Ahli'>
            </div>

            <button class="searchBtn" type='submit' value='Cari' data-tooltip="Cari">
                <i class='bx bx-search'></i>
            </button>
        </form>
    </div>
    <div class="upload-container">
        <button class="uploadBtn" data-tooltip="Muat Naik Ahli">
            <a href='upload.php'><i class='bx bx-upload'></i></a>
        </button>
    </div>
</div>

<div class="table-container">
    <div class="scrollable-table">
        <table class="table">
            <thead>

                <tr>
                    <th>Nama</th>
                    <th>No. Kad Pengenalan</th>
                    <th>Kelas</th>
                    <th>Katalaluan</th>
                    <th>Tahap</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                # Syarat tambahan yang akan dimasukkan dalam arahan(query) senarai ahli
                $tambahan = "";
                if (!empty($_POST["nama"])) {
                    $tambahan = " and ahli.nama like '%" . $_POST['nama'] . "%'";
                }

                # Arahan query untuk mencari senarai nama ahli
                $arahan_papar = "select * from ahli, kelas where ahli.IDkelas = kelas.IDkelas $tambahan ";

                # Laksana arahan mencari data ahli
                $laksana = mysqli_query($condb, $arahan_papar);

                # Mengambil data yang ditemui
                while ($m = mysqli_fetch_array($laksana)) {

                    # Umpukkan data kepda tatasusunan bagi tujuan kemaskini ahli
                    $data_get = array(
                        'nama' => $m['nama'],
                        'nokp' => $m['nokp'],
                        'katalaluan' => $m['katalaluan'],
                        'tahap' => $m['tahap'],
                        'IDkelas' => $m['IDkelas'],
                        'ting' => $m['ting'],
                        'nama_kelas' => $m['nama_kelas'],
                    );

                    # Memaparkan senarai nama dalam jadual
                    echo "<tr>
        <td>" . $m['nama'] . "</td>
        <td>" . $m['nokp'] . "</td>
        <td>" . $m['ting'] . " " . $m['nama_kelas'] . "</td>
        <td>" . $m['katalaluan'] . "</td>
        <td>" . $m['tahap'] . "</td>
        ";

                    # Memaparkan navigasi untuk kemaskini dan hapus data ahli
                    echo "<td>
        |<a href='ahli-kemaskini-borang.php?" . http_build_query($data_get) . "'>Kemaskini</a>
        |<a href='ahli-padam-proses.php?nokp=" . $m['nokp'] . "'
        onClick=\"return confirm('Anda pasti anda ingin memadam data ini?')\">Hapus</a>|
        
        </td>
        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>