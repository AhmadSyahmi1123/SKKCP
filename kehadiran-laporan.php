<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, connection.php dan kawalan-admin.php
include("header.php");
include("connection.php");
include("kawalan-admin.php");
?>

<h3>Laporan Kehadiran Aktiviti</h3>
<!-- Borang Carian Aktiviti -->
<form action="" method="GET" >
    Aktiviti <select name="IDaktiviti" >
        <option selected disabled value>Sila Pilih Aktiviti</option>

        <?php
        # Proses memaparkan senarai aktiviti dalam bentuk dropdown list
        $arahan_sql_pilih = "select * from aktiviti";
        $laksana_arahan_pilih = mysqli_query($condb,$arahan_sql_pilih);
        while($n=mysqli_fetch_array($laksana_arahan_pilih)){
            echo "<option value='".$n['IDaktiviti']."'>
            ".$n['IDaktiviti']." | ".$n['nama_aktiviti']."
            </option>";
        }
        ?>
        </select>
        <input type="submit" value="Cari" >
</form>

<?php
# Syarat tambahan yang akan dimasukkan dalam arahan SQL (query) senarai aktiviti
$tambahan = "";
if(!empty($_GET["IDaktiviti"])){
    # Mengambil nilai data GET di URL
    $IDaktiviti = $_GET["IDaktiviti"];

    # Proses mendapatkan maklumat aktiviti
    $sql_aktiviti = "select * from aktiviti where IDaktiviti='$IDaktiviti'";
    $laksana_aktiviti = mysqli_query($condb, $sql_aktiviti);
    $ma = mysqli_fetch_array($laksana_aktiviti);

    # Mendapatkan analisis kehadiran (bil_hadir & bil_ahli)
    $arahan_SQL = "SELECT 
    (SELECT COUNT(*) FROM kehadiran where IDaktiviti = '".$ma['IDaktiviti']."') AS bil_hadir,
    (SELECT COUNT(*) FROM ahli) AS bil_ahli ";
    $laksana_SQL = mysqli_query($condb, $arahan_SQL);
    $da = mysqli_fetch_array($laksana_SQL);
?>

<!-- Header bagi jadual untuk memaparkan senarai aktiviti -->
<h3>
    <?= $ma['nama_aktiviti'] ?> <br>
    <?= $ma['tarikh_aktiviti'] ?> | <?= $ma['masa_mula'] ?> <br>
    Kehadiran : <?= $da['bil_hadir']."/".$da['bil_ahli'] ?> <br>
    Peratus : <?php echo number_format(($da['bil_hadir']/$da['bil_ahli']*100), 2);
    ?>
</h3>

<table align='center' width='100%' border='1' id="saiz" >
    <tr bgcolor='cyan' >
        <td colspan="3">

        <form action="kehadiran-laporan.php?IDaktiviti=<?= $IDaktiviti ?>" method="POST" style="margin:0; padding:0;" >

        <input type="text" name="nama" placeholder="Carian Nama Ahli" >
        <input type="submit" value="Cari" >
        </form>

        </td>
    </tr>
    <tr bgcolor='yellow' >
        <td>Bil</td>
        <td>Nama</td>
        <td>No Kad Pengenalan</td>
        <td>Kelas</td>
        <td>Kehadiran</td>
    </tr>

<?php
# Syarat tambahan yang akan dimasukkan dalam arahan(query) senarai ahli
$tambahan = "";
if(!empty($_POST["nama"])){
    $tambahan = "where ahli.nama like '%".$_POST['nama']."%'";
}

# Arahan query untuk mencari senarai aktiviti
$arahan_papar = "
SELECT *, ahli.nokp
FROM ahli
LEFT JOIN kelas
ON ahli.IDkelas = kelas.IDkelas
LEFT JOIN kehadiran
ON ahli.nokp = kehadiran.nokp
and IDaktiviti like '%$IDaktiviti%'
$tambahan
ORDER BY ahli.nama
";

# Laksana arahan mencari data aktiviti
$laksana = mysqli_query($condb, $arahan_papar);
$hadir = $tak_hadir = $bil = 0;

# Mengambil data yang ditemui
while($m = mysqli_fetch_array($laksana)){
    # Memaparkan senarai nama dalam jadual
    echo "<tr>
    <td>".++$bil."</td>
    <td>".$m['nama']."</td>
    <td>".$m['nokp']."</td>
    <td>".$m['ting']." | ".$m['nama_kelas']."</td>
    <td align='center' >
    ";

    if(strlen($m['IDaktiviti']) >= 1){
        echo "&#9989;";
    }
    else{
        echo "&#10060;";
    }

    echo "<?td>
    
    
    </tr>";
}
echo "</table>";
}
?>