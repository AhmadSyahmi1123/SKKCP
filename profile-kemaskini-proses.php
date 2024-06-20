<?php
# Memulakan fungsi session
session_start();

# Semak kewujudan data POST
if (!empty($_POST)) {
    # Memanggil fail connection.php
    include ("connection.php");

    # Pengesahan data nokp ahli
    if (strlen($_POST["nokp"]) != 12 or !is_numeric($_POST["nokp"])) {
        die("<script>alert('Ralat No Kad Pengenalan');
        window.history.back();</script>");
    }

    if (isset($_POST['submit'])) {
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
            $unique_filename = $_POST["nokp"] . '.' . $imageFileType;
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

        # Arahan SQL (query) untuk kemaskini maklumat ahli
        $arahan = "UPDATE ahli SET
            nama = '" . strtoupper($_POST['nama']) . "',
            nokp = '" . $_POST['nokp'] . "',
            katalaluan = '" . $_POST['katalaluan'] . "',
            IDkelas = '" . $_POST['IDkelas'] . "',
            tahap = '" . $_SESSION['tahap'] . "'";

        // Add condition to update profile_pic only if it's changed
        if (isset($unique_filename)) {
            $arahan .= ", profile_pic = '" . $unique_filename . "'";
        }

        $arahan .= " WHERE nokp = '" . $_SESSION['nokp'] . "'";

        $laksana_arahan = mysqli_query($condb, $arahan);

        # Laksana dan semak proses kemaskini
        if ($laksana_arahan) {
            # Kemaskini berjaya

            # Kemaskini info di profil.php
            $_SESSION['nama'] = $_POST['nama'];
            $_SESSION['nokp'] = $_POST['nokp'];
            $_SESSION['katalaluan'] = $_POST['katalaluan'];
            $_SESSION['IDkelas'] = $_POST['IDkelas'];
            // Update profile_pic only if it's changed
            if (isset($unique_filename)) {
                $_SESSION['profile_pic'] = $unique_filename;
            }

            // Fetch ting and nama_kelas based on new IDkelas value
            $fetch_kelas = mysqli_query($condb, "SELECT ting, nama_kelas FROM kelas WHERE IDkelas = '" . $_POST['IDkelas'] . "'");
            $row_kelas = mysqli_fetch_assoc($fetch_kelas);

            // Update session variables with fetched values
            $_SESSION['ting'] = $row_kelas['ting'];
            $_SESSION['nama_kelas'] = $row_kelas['nama_kelas'];

            $message = "Kemaskini Berjaya!";
            $notificationType = 'success';
            $notificationMessage = $message;
        } else {
            # Kemaskini gagal
            $message = "Ralat! Kemaskini Gagal!";
            $notificationType = 'error';
            $notificationMessage = $message;
        }
        header("Location: profil.php?notificationType=$notificationType&notificationMessage=$notificationMessage");
        exit();
    }
} else {
    # Jika data GET tidak wujud, kembali ke fail profil.php
    die("<script>alert('Sila lengkapkan data');
    window.location.href='profil.php';</script>");
}