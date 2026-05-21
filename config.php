<?php
$host = "kodama.proxy.rlwy.net"; // MYSQLHOST
$user = "root";                  // MYSQLUSER
$pass = "ISI_PASSWORD_RAILWAY"; // BTDqJLWHKlclZxkgVIGnkWOjLAbrVoab
$db   = "railway";               // MYSQLDATABASE
$port = "22092";                 // MYSQLPORT

$koneksi = mysqli_connect($host, $user, $pass, $db, $port);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
