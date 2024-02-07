<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, connection.php dan kawalan-admin.php
include("header.php");
include("connection.php");
include("kawalan-admin.php");

?>
<h3 align='center'> Senarai Aktiviti </h3>

<!-- Header bagi jadual untuk memaparkan senarai aktiviti -->
<table align='center' width='100%' border='1' id='saiz'>
    <tr bgcolor='cyan'>
        <td>
            <form action='' method='POST' style="margin:0; padding:0;" >
                <input type="text" name='nama_aktiviti' placeholder='Carian Aktiviti' >
                <input type="submit" value='Cari' >
            </form>
        </td>
        <td colspan='2' align='right' >
            | <a href='aktiviti-daftar-borang.php'>Daftar Aktiviti/Perjumpaan Baru</a> |
        </td>
    </tr>
    <tr bgcolor='yellow' align='center' >
        <td>Nama Aktiviti</td>
        <td>Tarikh | Masa</td>
        <td>Tindakan</td>
    </tr>

    <?php
    # Syarat tambahan yang akan dimasukkan dalam arahan(query) senarai aktiviti
    $tambahan = "";
    if(!empty($_POST["nama_aktiviti"])){
        $tambahan = "where nama_aktiviti like '%".$_POST['nama_aktiviti']."%'";
    }

    # Araham query untuk mencari senarai aktiviti
    $arahan_papar = "select * from aktiviti $tambahan";

    # Laksana arahan mencari senarai aktiviti
    $laksana = mysqli_query($condb, $arahan_papar);

    # Mengambil data yang ditemui
    while($m = mysqli_fetch_array($laksana)){

        # Memaparkan senarai aktiviti dalam jadual
        echo "<tr>
        <td>".$m['nama_aktiviti']."</td>
        <td>".$m['tarikh_aktiviti']." | ".$m['masa_mula']."</td>
        ";

        # Memaparkan navigasi untuk kemaskini dan hapus data aktiviti
        echo "<td align='right'>
        | <a href='aktiviti-kemaskini-borang.php?IDaktiviti=".$m['IDaktiviti']."'>Kemaskini</a> |
        | <a href='aktiviti-padam-proses.php?IDaktiviti=".$m['IDaktiviti']."' onClick=\"return confirm('Anda pasti anda ingin memadam data ini?')\">Hapus</a> |
        | <a href='kehadiran-borang.php?IDaktiviti=".$m['IDaktiviti']."'>Pengesahan Kehadiran</a> |
        </tr>";
    }
    ?>