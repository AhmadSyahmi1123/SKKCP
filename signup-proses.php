<?php
# Memulakan fungsi session
session_start();

# Menyemak kewujudan data POST
if (!empty($_POST)) {

    # Memanggil fail connection.php
    include ("connection.php");

    # Mengambil data yang dihantar dari fail signup-borang.php
    $nama = strtoupper($_POST["nama"]);
    $nokp = $_POST["nokp"];
    $IDkelas = $_POST["IDkelas"];
    $katalaluan = $_POST["katalaluan"];
    $profile_pic = $_FILES['profile_pic'];

    $img_name = $_FILES['profile_pic']['name'];
    $img_size = $_FILES['profile_pic']['size'];
    $tmp_name = $_FILES['profile_pic']['tmp_name'];
    $error = $_FILES['profile_pic']['error'];

    // Check if file was uploaded without errors
    if (isset($_FILES["profile_pic"]) && $error == 0) {
        $target_dir = "uploads/";
        $imageFileType = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));

        // Generate a unique filename
        $unique_filename = $nokp . '.' . $imageFileType;
        $target_file = $target_dir . $unique_filename;

        if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
            if (move_uploaded_file($tmp_name, $target_file)) {
                $file_path = $target_file;
                // Insert $file_path into your database along with other user information
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Sorry, only JPG, JPEG, PNG files are allowed.";
        }
    }

    # Data Validation
    # nokp yang dimasukkan hendaklah 12 digit dan tidak mempunyai huruf/simbol
    if (strlen($nokp) != 12 or !is_numeric($nokp)) {
        $message = "Sila Masukkan No. Kad Pengenalan Yang Sah!";
        $notificationType = 'error';
        $notificationMessage = $message;

        header("Location: signup-borang.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
        exit();
    }

    # Menyemak jika nokp yang dimasukkan wujud dalam pangkalan data
    $arahan_sql_semak = "select* from ahli where nokp='$nokp' limit 1";
    $laksana_arahan_semak = mysqli_query($condb, $arahan_sql_semak);
    if (mysqli_num_rows($laksana_arahan_semak) == 1) {
        # Jika nokp tang dimasukkan telah wujud, aturcara akan berhenti
        $message = "No. Kad Pengenalan telah wujud dalam sistem!";
        $notificationType = 'error';
        $notificationMessage = $message;

        header("Location: signup-borang.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
        exit();
    }

    # Arahan SQL (query) untuk menyimpan data ahli baru
    $arahan_sql_simpan = "insert into ahli (nokp, nama, IDkelas, katalaluan, tahap, profile_pic) values ('$nokp', '$nama', '$IDkelas','$katalaluan', 'BIASA', '$unique_filename')";
    # Melaksanakan arahan SQL menyimpan data ahli baru
    $laksana_arahan_simpan = mysqli_query($condb, $arahan_sql_simpan);

    # Menguji jika proses menyimpan data berjaya atau tidak
    if ($laksana_arahan_simpan) {
        #Jika berjaya, papar popup dan buka fail ahli-login-borang
        $message = "Data Berjaya Didaftar!";
        $notificationType = 'success';
        $notificationMessage = $message;

        header("Location: login-borang.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
        exit();
    } else {
        # Jika tidak berjaya, papar popup dan buka fail signup-borang
        $message = "Data Gagal Didaftar!";
        $notificationType = 'error';
        $notificationMessage = $message;

        header("Location: signup-borang.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
        exit();
    }
} else {
    # Jika pengguna buka fail ini tanpa mengisi data, papar popup dan buka fail signup-borang
    $message = "Sila Lengkapkan Maklumat!";
    $notificationType = 'error';
    $notificationMessage = $message;

    header("Location: signup-borang.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
    exit();
}
