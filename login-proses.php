<?php
# Memulakan fungsi session
session_start();

# Menyemak kewujudan data POST yang dihantar dari login-borang.php
if(!empty($_POST['nokp']) and !empty( $_POST['katalaluan'])){

    # Memanggil fail connection.php
    include('connection.php');

    # Mengambil data yang di POST dari fail borang
    $nokp = $_POST['nokp'];
    $katalaluan = $_POST['katalaluan'];

    # Arahan SQL(query) untuk membandingkan data yang dimasukkan wujud dalam pangkalan data atau tidak
    $query_login = "select * from ahli where nokp = '$nokp' and katalaluan = '$katalaluan' limit 1";
    # Melaksanakan arahan membandingkan data
    $laksana_query = mysqli_query($condb, $query_login);

    # Jika terdapat 1 data yang padan, log masuk berjaya
    if(mysqli_num_rows($laksana_query) == 1){
        # Mengambil data yang ditemui
        $m = mysqli_fetch_array($laksana_query);

        # Mengumpukkan kepada pembolehubah session
        $_SESSION["nokp"] = $m["nokp"];
        $_SESSION["tahap"] = $m["tahap"];
        $_SESSION["nama"] = $m["nama"];

        # Buka laman index.php
        if ($_SESSION["tahap"] == "ADMIN"){
            echo "<script>window.location.href='index-admin.php'; </script>";
        }
        else {
            echo "<script>window.location.href='index-biasa.php'; </script>";
        }
        
    }
    else{
        # Jika tidak, log masuk gagal. Kembali ke laman login-borang.php
        die("<script>alert('Log Masuk Gagal');
        window.location.href='login-borang.php'; </script>");
    }
}
else{
    # Data yang dihantar dari laman login-borang.php kosong
    die("<script>alert('Sila Masukkan No. Kad Pengenalan dan Katalaluan');
    window.location.href='login-borang.php'; </script>");
}
?>