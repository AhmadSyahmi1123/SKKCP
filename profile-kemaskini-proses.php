<?php
# Memulakan fungsi session
session_start();

# Semak kewujudan data POST
if (!empty($_POST)) {
    # Memanggil fail connection.php
    include("connection.php");

    # Pengesahan data nokp ahli
    if (strlen($_POST["nokp"]) != 12 or !is_numeric($_POST["nokp"])) {
        die("<script>alert('Ralat No Kad Pengenalan');
        window.history.back();</script>");
    }

    # Arahan SQL (query) untuk kemaskini maklumat ahli
    $arahan = "UPDATE ahli SET
    nama = '" . strtoupper($_POST['nama']) . "',
    nokp = '" . $_POST['nokp'] . "',
    katalaluan = '" . $_POST['katalaluan'] . "',
    IDkelas = '" . $_POST['IDkelas'] . "',
    tahap = '" . $_SESSION['tahap'] . "'
    WHERE
    nokp = '" . $_SESSION['nokp'] . "'
    ";

    # Laksana dan semak proses kemaskini
    if (mysqli_query($condb, $arahan)) {
        # Kemaskini berjaya

        # Kemaskini info di profil.php
        $_SESSION['nama'] = $_POST['nama'];
        $_SESSION['nokp'] = $_POST['nokp'];
        $_SESSION['katalaluan'] = $_POST['katalaluan'];
        $_SESSION['IDkelas'] = $_POST['IDkelas'];

        echo "<script>alert('Kemaskini Berjaya!');
        window.location.href='profil.php';</script>";
    } else {
        # Kemaskini gagal
        echo "<script>alert('Kemaskini Gagal');
        window.history.back();</script>";
    }
} else {
    # Jika data GET tidak wujud, kembali ke fail profil.php
    die("<script>alert('Sila lengkapkan data');
    window.location.href='profil.php';</script>");
}