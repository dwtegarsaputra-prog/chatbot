<?php
// Pengaturan Database Railway
$host = "kodama.proxy.rlwy.net"; 
$user = "root";                  
$pass = "BTDqJLWHKlclZxkgVIGnkWOjLAbrVoab"; 
$db   = "railway";               
$port = "22092";                 

// Koneksi mysqli (untuk admin/web jika ada)
$koneksi = mysqli_connect($host, $user, $pass, $db, $port);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Pengaturan API Telegram (PENTING untuk webhook.php)
define('TELEGRAM_API', 'https://api.telegram.org/bot8749239208:AAFyJIvjIhGT9VpEW65nDtyLjSAwXa2YHao/');
?>
