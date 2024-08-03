<?php
# Menetapkan zon waktu kepada Kuala Lumpur
date_default_timezone_set("Asia/Kuala_Lumpur");

# Nama host pangkalan data. 'localhost' adalah default
$nama_host = "localhost";

# Nama pengguna bagi sambungan SQL. 'root' adalah default
$nama_sql = "root";

# Kata laluan bagi sambungan SQL. Kosong jika tiada kata laluan
$pass_sql = "";

# Nama pangkalan data yang digunakan
$nama_db = "kehadiran_ahli";

# Membuka hubungan antara aplikasi dengan pangkalan data menggunakan mysqli
$condb = mysqli_connect($nama_host, $nama_sql, $pass_sql, $nama_db);

# Semak jika sambungan ke pangkalan data berjaya
if (!$condb) {
    die("Gagal menyambung ke pangkalan data: " . mysqli_connect_error());
}