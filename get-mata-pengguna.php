<?php
# Memulakan sesi PHP untuk mendapatkan maklumat pengguna
session_start();

# Memanggil fail sambungan ke pangkalan data
include ("connection.php");

# Mendapatkan ID pengguna dari sesi
$userId = $_SESSION['nokp'];

# Arahan SQL untuk mendapatkan mata pengguna berdasarkan nokp
$sql = "SELECT mata FROM ahli WHERE nokp = '$userId'";

# Melaksanakan arahan SQL untuk mendapatkan maklumat mata pengguna
$result = mysqli_query($condb, $sql);

# Mengambil data yang ditemui dari hasil query
$user = mysqli_fetch_assoc($result);

# Memulangkan data dalam format JSON
echo json_encode($user);