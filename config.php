<?php
$host = "kodama.proxy.rlwy.net"; 
$user = "root";                  
$pass = "BTDqJLWHKlclZxkgVIGnkWOjLAbrVoab"; 
$db   = "railway";               
$port = "22092";                 

$koneksi = mysqli_connect($host, $user, $pass, $db, $port);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Tambahkan baris ini di bawah agar webhook.php tidak error!
define('TELEGRAM_API', 'https://api.telegram.org/bot8749239208:AAFyJIvjIhGT9VpEW65nDtyLjSAwXa2YHao/');
?>
