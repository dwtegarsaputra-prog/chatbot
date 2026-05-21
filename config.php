<?php
// Pengaturan Database Railway
$host = "kodama.proxy.rlwy.net"; 
$user = "root";                  
$pass = "BTDqJLWHKlclZxkgVIGnkWOjLAbrVoab"; 
$db   = "railway";               
$port = "22092";                 

// Simpan variabel ke konstanta agar webhook.php tidak bingung
define('DB_HOST', $host);
define('DB_USER', $user);
define('DB_PASS', $pass);
define('DB_NAME', $db);
define('DB_PORT', $port);

// Koneksi PDO (Gunakan port)
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Telegram Bot
define('TELEGRAM_TOKEN', '8749239208:AAFyJIvjIhGT9VpEW65nDtyLjSAwXa2YHao');
define('TELEGRAM_API', 'https://api.telegram.org/bot'.TELEGRAM_TOKEN.'/');
?>
