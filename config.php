<?php
// --- Database MySQL ---
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_USER')) define('DB_USER', 'root'); // sesuaikan user
if (!defined('DB_PASS')) define('DB_PASS', '');     // sesuaikan password
if (!defined('DB_NAME')) define('DB_NAME', 'smkku');

// --- Koneksi PDO tunggal ---
try {
    $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

// --- WhatsApp Bot (Fonnte) ---
// Token telah diperbarui menjadi S7jei1PYJYysezn2RGGy
if (!defined('WA_TOKEN')) define('WA_TOKEN', 'S7jei1PYJYysezn2RGGy');

// --- Telegram Bot ---
if (!defined('TELEGRAM_TOKEN')) define('TELEGRAM_TOKEN', '8749239208:AAFyJIvjIhGT9VpEW65nDtyLjSAwXa2YHao');
if (!defined('TELEGRAM_API')) define('TELEGRAM_API', 'https://api.telegram.org/bot'.TELEGRAM_TOKEN.'/');
?>