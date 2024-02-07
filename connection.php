<?php
date_default_timezone_set("Asia/Kuala_Lumpur");

# nama host. localhost merupakan default
$nama_host = "localhost";

# username bagi SQL. root merupakan default
$nama_sql = "root";

# password bagi SQL.
$pass_sql = "";

# nama pangkalan data 
$nama_db = "kehadiran_ahli";

# membuka hubungan antara pangkalan data dan sistem
$condb = mysqli_connect($nama_host, $nama_sql, $pass_sql, $nama_db);

# Menguji jika hubungan berjaya dibuka
if(!$condb){
    die("Sambungan ke pangkalan data gagal");
}
else{
    echo "Sambungan ke pangkalan data berjaya";
}
?>