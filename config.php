<?php
// Data Database Railway
$host = "kodama.proxy.rlwy.net"; 
$user = "root";                  
$pass = "BTDqJLWHKlclZxkgVIGnkWOjLAbrVoab"; 
$db   = "railway";               
$port = "22092";                 

// Mendefinisikan konstanta agar dikenali oleh webhook.php
define('DB_HOST', $host);
define('DB_USER', $user);
define('DB_PASS', $pass);
define('DB_NAME', $db);
define('DB_PORT', $port);

// Koneksi PDO (Menggunakan Port Railway)
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Jika gagal konek, biarkan aplikasi tetap jalan tapi catat error
}

// Token Telegram
define('TELEGRAM_TOKEN', '8749239208:AAFyJIvjIhGT9VpEW65nDtyLjSAwXa2YHao');
define('TELEGRAM_API', 'https://api.telegram.org/bot'.TELEGRAM_TOKEN.'/');
?>
