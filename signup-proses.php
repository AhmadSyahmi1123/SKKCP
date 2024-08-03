<?php
# Memulakan sesi pengguna
session_start();

# Menyemak jika data POST wujud
if (!empty($_POST)) {

    # Memanggil fail connection.php untuk sambungan ke pangkalan data
    include ("connection.php");

    # Mengambil data yang dihantar dari borang pendaftaran
    $nama = strtoupper($_POST["nama"]); # Menukar nama ke huruf besar
    $nokp = $_POST["nokp"]; # No. Kad Pengenalan
    $IDkelas = $_POST["IDkelas"]; # ID Kelas
    $katalaluan = $_POST["katalaluan"]; # Katalaluan

    # Mengambil maklumat fail gambar profil
    $img_name = $_FILES['profile_pic']['name'];
    $img_size = $_FILES['profile_pic']['size'];
    $tmp_name = $_FILES['profile_pic']['tmp_name'];
    $error = $_FILES['profile_pic']['error'];

    $file_path = "";

    # Semak jika fail gambar diupload
    if ($error == UPLOAD_ERR_NO_FILE) {
        # Jika tiada fail yang diupload, gunakan gambar default
        $file_path = "default-avatar.png";
    } else {
        # Semak jika fail gambar diupload tanpa ralat
        if (isset($_FILES["profile_pic"]) && $error == 0) {
            $target_dir = "uploads/";
            $imageFileType = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));

            # Jana nama fail unik
            $unique_filename = $nokp . '.' . $imageFileType;
            $target_file = $target_dir . $unique_filename;

            # Semak jenis fail dan jika ia boleh dimuat naik
            if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
                if (move_uploaded_file($tmp_name, $target_file)) {
                    $file_path = $unique_filename; # Simpan nama fail
                } else {
                    echo "Maaf, terdapat ralat semasa memuat naik fail anda.";
                }
            } else {
                echo "Maaf, hanya fail JPG, JPEG, PNG yang dibenarkan.";
            }
        }
    }

    # Validasi data
    # Nokp hendaklah 12 digit dan tidak mengandungi huruf atau simbol
    if (strlen($nokp) != 12 or !is_numeric($nokp)) {
        $message = "Sila Masukkan No. Kad Pengenalan Yang Sah!";
        $notificationType = 'error';
        $notificationMessage = $message;

        header("Location: signup-borang.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
        exit();
    }

    # Semak jika nokp yang dimasukkan telah wujud dalam pangkalan data
    $arahan_sql_semak = "SELECT * FROM ahli WHERE nokp='$nokp' LIMIT 1";
    $laksana_arahan_semak = mysqli_query($condb, $arahan_sql_semak);
    if (mysqli_num_rows($laksana_arahan_semak) == 1) {
        # Jika nokp telah wujud, redirect ke borang signup dengan mesej ralat
        $message = "No. Kad Pengenalan telah wujud dalam sistem!";
        $notificationType = 'error';
        $notificationMessage = $message;

        header("Location: signup-borang.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
        exit();
    }

    # Arahan SQL untuk menyimpan data ahli baru
    $arahan_sql_simpan = "INSERT INTO ahli (nokp, nama, IDkelas, katalaluan, tahap, profile_pic) 
                          VALUES ('$nokp', '$nama', '$IDkelas', '$katalaluan', 'BIASA', '$file_path')";
    # Melaksanakan arahan SQL
    $laksana_arahan_simpan = mysqli_query($condb, $arahan_sql_simpan);

    # Uji jika penyimpanan data berjaya
    if ($laksana_arahan_simpan) {
        # Jika berjaya, redirect ke halaman login dengan mesej kejayaan
        $message = "Data Berjaya Didaftar!";
        $notificationType = 'success';
        $notificationMessage = $message;

        header("Location: login-borang.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
        exit();
    } else {
        # Jika gagal, redirect ke borang signup dengan mesej ralat
        $message = "Data Gagal Didaftar!";
        $notificationType = 'error';
        $notificationMessage = $message;

        header("Location: signup-borang.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
        exit();
    }
} else {
    # Jika fail dibuka tanpa data POST, redirect ke borang signup dengan mesej ralat
    $message = "Sila Lengkapkan Maklumat!";
    $notificationType = 'error';
    $notificationMessage = $message;

    header("Location: signup-borang.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
    exit();
}