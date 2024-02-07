<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header.php, kawalan-admin.php dan connection.php
include("header.php");
include("kawalan-admin.php");
include("connection.php");

$masa = date("H:i:s");
$status = ""; # Digunakan untuk memaparkan status kehadiran
$warna = ""; # Digunakan untuk warna latar belakang status

# Menyemak kewujudan data POST
if(!empty($_POST["nokp"])){
    # Menyemak jika nokp yang dimasukkan telah wujud dalam pangkalan data
    $arahan_sql_semak = "select * from ahli where nokp = '".$_POST['nokp']."' ";
    # Laksana arahan semak
    $laksana_arahan_semak = mysqli_query($condb,$arahan_sql_semak);
    if(mysqli_num_rows($laksana_arahan_semak) != 1){
        # Jika nokp yang dimasukkan telah wujud
        $status = "No. Kad Pengenalan yang dimasukkan/diimbas tiada dalam sistem";
        $warna = "red";
    }
    else{
        # Menyemak jika nokp yang dimasukkan telah direkodkan dalam pangkalan data kehadiran
        $arahan_semak = "select * from kehadiran where nokp='".$_POST['nokp']."' and IDaktiviti='".$_GET['IDaktiviti']."' limit 1";
        $laksana_arahan = mysqli_query($condb,$arahan_semak);

        if(mysqli_num_rows($laksana_arahan) == 1){
            $status = "Anda telah mengesahkan kehadiran sebelum ini";
            $warna = "red";
        }
        else{
            # Menyimpan data kehadiran
            $simpan_data = mysqli_query($condb,"insert into kehadiran (IDaktiviti, nokp, masa_hadir) values ('".$_GET['IDaktiviti']."', '".$_POST['nokp']."', '$masa')");

            # Menyemak jika proses penyimpanan data berjaya
            if($simpan_data){
                $status = "Kehadiran Telah Disahkan";
                $warna = "green";
            }
            else{
                $status = "Kehadiran Gagal Direkodkan";
                $warna = "red";
            }
        }
    }
}

# Menyemak kewujudan data GET['IDaktiviti']
if(!empty($_GET['IDaktiviti'])){
    # Proses mendapatkan data aktiviti
    $sql_aktiviti = "select * from aktiviti where IDaktiviti = '".$_GET['IDaktiviti']."'";
    $laksana_aktiviti = mysqli_query($condb,$sql_aktiviti);
    $ma = mysqli_fetch_array($laksana_aktiviti);
}
?>

<h1 align='center'>Laman Rekod Kehadiran Kaunter Urusetia</h1>
<h3 align='center'>
    <!-- Borang carian aktiviti -->
    <form action='' method='GET'>
        Aktiviti <select name='IDaktiviti'>
        <option selected disabled value>Sila Pilih Aktiviti</option>

        <?php
        # Proses memaparkan senarai aktiviti dalam bentuk dropdown list
        $arahan_sql_pilih = "select * from aktiviti";
        $laksana_arahan_pilih = mysqli_query($condb,$arahan_sql_pilih);

        while($n=mysqli_fetch_array($laksana_arahan_pilih)){
            echo "<option value='".$n['IDaktiviti']."'>
            ".$n['IDaktiviti']." | ".$n['nama_aktiviti']."</option>";
        }
        ?>
        </select>

        <input type='submit' value='Cari'>
    </form>

    <?php if(!empty($_GET["IDaktiviti"])) { ?>
        <!-- Header bagi jadual untuk memaparkan senarai aktiviti -->
        <?= $ma['nama_aktiviti']?><br>
        <?= $ma['tarikh_aktiviti']?> | <?= $ma['masa_mula']?> <br>
</h3>

<form align='center' action='' method='POST'>
    <label>Masukkan/Imbas Kod QR anda di sini</label> <br>
    <input type='text' name='nokp' autofocus autocomplete="off" required onblur="this.focus()"> <br>
    <input type='submit' value='Rekod Kehadiran'>
</form>

<table width='50%' border='1' align='center'>
    <caption style="background-color :<?= $warna ?>"> <h3><?=$status; ?></h3> </caption>
    <tr bgcolor='yellow'>
        <td>#</td>
        <td>Nama</td>
        <td>No. Kad Pengenalan</td>
        <td>Kelas</td>
        <td>Masa Hadir</td>
    </tr>
    <?php
    $bil=0;

    # Memaparkan data kehadiran dalam bentuk jadual
    $arahan_sql_kehadiran = "select * from ahli, aktiviti, kehadiran, kelas where ahli.nokp=kehadiran.nokp and ahli.IDkelas=kelas.IDkelas and aktiviti.IDaktiviti=kehadiran.IDaktiviti and kehadiran.IDaktiviti='".$_GET['IDaktiviti']."' order by kehadiran.masa_hadir DESC";
    $laksana_kehadiran = mysqli_query($condb,$arahan_sql_kehadiran);

    while($m=mysqli_fetch_array($laksana_kehadiran)){
        echo "<tr>
                <td>".++$bil."</td>
                <td>".$m['nama']."</td>
                <td>".$m['nokp']."</td>
                <td>".$m['ting']." ".$m['nama_kelas']."</td>
                <td>".$m['masa_hadir']."</td>
              </tr>";
    }
?>
</table>
<?php } ?>