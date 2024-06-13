<?php
# Memulakan fungsi session
session_start();

# Menyemak kewujudan data POST yang dihantar dari login-borang.php
if (!empty($_POST['nokp']) and !empty($_POST['katalaluan'])) {

    # Memanggil fail connection.php
    include ('connection.php');

    # Mengambil data yang di POST dari fail borang
    $nokp = $_POST['nokp'];
    $katalaluan = $_POST['katalaluan'];

    # Arahan SQL(query) untuk membandingkan data yang dimasukkan wujud dalam pangkalan data atau tidak
    $query_login = "SELECT ahli.*, kelas.* 
                FROM ahli 
                INNER JOIN kelas ON ahli.IDkelas = kelas.IDkelas 
                WHERE ahli.nokp = '$nokp' AND ahli.katalaluan = '$katalaluan' 
                LIMIT 1";

    # Melaksanakan arahan membandingkan data
    $laksana_query = mysqli_query($condb, $query_login);

    # Jika terdapat 1 data yang padan, log masuk berjaya
    if (mysqli_num_rows($laksana_query) == 1) {
        # Mengambil data yang ditemui
        $m = mysqli_fetch_array($laksana_query);

        # Mengumpukkan kepada pembolehubah session
        $_SESSION["nokp"] = $m["nokp"];
        $_SESSION["tahap"] = $m["tahap"];
        $_SESSION["nama"] = $m["nama"];
        $_SESSION["katalaluan"] = $m["katalaluan"];
        $_SESSION["profile_pic"] = $m["profile_pic"];
        $_SESSION["ting"] = $m["ting"];
        $_SESSION["nama_kelas"] = $m["nama_kelas"];
        $_SESSION["IDkelas"] = $m["IDkelas"];

        # Buka laman index.php
        if ($_SESSION["tahap"] == "ADMIN") {
            $message = "Log Masuk Berjaya!";
            $notificationType = 'success';
            $notificationMessage = $message;

            header("Location: index-admin.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
            exit();
        } else {
            $message = "Log Masuk Berjaya!";
            $notificationType = 'success';
            $notificationMessage = $message;

            header("Location: index-biasa.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
            exit();
        }

    } else {
        # Jika tidak, log masuk gagal. Kembali ke laman login-borang.php
        $message = "Log Masuk Gagal!";
        $notificationType = 'error';
        $notificationMessage = $message;

        header("Location: login-borang.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
        exit();
    }
} else {
    # Data yang dihantar dari laman login-borang.php kosong
    $message = "Sila Masukkan No. Kad Pengenalan dan Katalaluan!";
    $notificationType = 'error';
    $notificationMessage = $message;

    header("Location: login-borang.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
    exit();
}