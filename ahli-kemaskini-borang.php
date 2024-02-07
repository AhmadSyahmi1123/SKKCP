<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header, fail kawalan-admin.php dan connection.php
include("header.php");
include("kawalan-admin.php");
include("connection.php");

# Menyemak kewujudan data GET. Jika data GET empty, buka fail senarai-ahli
if(empty($_GET)){
    die("<script>window.location.href='senarai-ahli.php';</script>");
}
?>

<h3>Kemaskini Ahli Baru</h3>
<form action="ahli-kemaskini-proses.php?nokp_lama=<?= $_GET['nokp'] ?>" method='POST'>
nama
<input type='text' name='nama' value='<?= $_GET['nama'] ?>' required> <br>

nokp
<input type='text' name='nokp' value='<?= $_GET['nokp'] ?>' required> <br>

katalaluan
<input type='text' name='katalaluan' value='<?= $_GET['katalaluan'] ?>' required> <br>

Tahap
<select name='tahap'><br>
<option value='<?= $_GET['tahap'] ?>'> <?= $_GET['tahap'] ?> </option>
<?php
    # Proses memaparkan senarai tahap dalam bentuk dropdown list
    $arahan_sql_tahap = "select tahap from ahli group by tahap order by tahap";
    $laksana_arahan_tahap = mysqli_query($condb,$arahan_sql_tahap);
    while($n=mysqli_fetch_array($laksana_arahan_tahap)){
        if($n["tahap"] != $_GET['tahap']){
            echo "<option value='".$n['tahap']."'></option>";
        }
    }
?>
</select> <br>

Tingkatan
<select name='IDkelas'><br>
<option value='<?= $_GET['IDkelas'] ?>'> <?= $_GET['ting'] ?>" "<?= $_GET['nama_kelas'] ?> </option>
<?php
    # Proses memaparkan senarai kelas dalam bentuk dropdown list
    $arahan_sql_pilih = "select * from kelas";
    $laksana_arahan_pilih = mysqli_query($condb,$arahan_sql_pilih);
    while($m=mysqli_fetch_array($laksana_arahan_pilih)){
        if($m["IDkelas"] != $_GET['IDkelas']){
            echo "<option value='".$m['IDkelas']."'> ".$m['ting']." ".$m['nama_kelas']." </option>";
        }
    }
?>
</select> <br>

<input type='submit' value='Kemaskini'>
</form>