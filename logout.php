<?php
# Memulakan fungsi session
session_start();

# Menghapuskan nilai pembolehubah session
session_unset();

# Menghentikan fungsi session
session_destroy();

echo "<script>window.location.href='index.php';</script>";