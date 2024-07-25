<?php
# Menyemak nilai pembolehubah session['tahap']
if (!empty($_SESSION['tahap'])) {
    if ($_SESSION['tahap'] != "BIASA") {
        # Jika nilainya tidak sama dengan BIASA, aturcara akan diberhentikan
        die("<script>alert('Sila Log Masuk');
        window.location.href='logout.php';</script>");
    }
} else {
    # Jika nilai session empty
    die("<script>alert('Sila Log Masuk');
        window.location.href='logout.php';</script>");
}