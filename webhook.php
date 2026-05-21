<?php
require 'config.php';

// Pastikan konstanta ini ada untuk mengirim pesan
if (!defined('TELEGRAM_API')) {
    define('TELEGRAM_API', 'https://api.telegram.org/bot8749239208:AAFyJIvjIhGT9VpEW65nDtyLjSAwXa2YHao/');
}

/**
 * Fungsi untuk mengirim pesan ke Telegram
 */
function sendMessageTelegram($chat_id, $text, $keyboard = null) {
    $url = TELEGRAM_API . "sendMessage";
    $data = [
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => 'HTML'
    ];
    if ($keyboard) $data['reply_markup'] = $keyboard;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_exec($ch);
    curl_close($ch);
}

// Menangkap input dari Telegram
$content = file_get_contents('php://input');
$update = json_decode($content, true);

if (isset($update['callback_query'])) {
    $chat_id = $update['callback_query']['message']['chat']['id'];
    $text = strtolower(trim($update['callback_query']['data']));
} elseif (isset($update['message'])) {
    $chat_id = intval($update['message']['chat']['id']);
    $text = strtolower(trim($update['message']['text']));
} else {
    exit;
}

/**
 * Struktur Menu Utama
 */
$menuUtama = json_encode([
    'inline_keyboard' => [
        [['text' => '🏫 Profil', 'callback_data' => 'profil'], ['text' => '🛠 Jurusan', 'callback_data' => 'jurusan']],
        [['text' => '📅 Jadwal', 'callback_data' => 'jadwal'], ['text' => '📝 Nilai', 'callback_data' => 'nilai']],
        [['text' => '🏆 Prestasi', 'callback_data' => 'prestasi'], ['text' => '📅 Kegiatan', 'callback_data' => 'event']],
        [['text' => '🏠 Menu Utama', 'callback_data' => 'menu']]
    ]
]);

// 1. Respon /start
if ($text === '/start') {
    $pesanStart = "<b>Selamat Datang di Chatbot SMKN 1 Kutasari</b>\n\nKetik <b>menu</b> untuk menampilkan pilihan informasi.";
    sendMessageTelegram($chat_id, $pesanStart);
    exit;
}

// 2. Respon menu
if ($text === 'menu') {
    $pesanMenu = "Silakan pilih kategori informasi di bawah ini:";
    sendMessageTelegram($chat_id, $pesanMenu, $menuUtama);
    exit;
}

// --- PERBAIKAN KONEKSI DATABASE ---
try {
    // Memakai variabel dari config.php
    $pdo = new PDO("mysql:host=$host;dbname=$db;port=$port", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) { 
    // Supaya kita tahu kalau error, bot akan chat kita
    sendMessageTelegram($chat_id, "Error Koneksi: " . $e->getMessage());
    exit; 
} 
}

// --- LOGIKA PENCARIAN ---
$query = "SELECT * FROM informasi_sekolah WHERE kategori LIKE :kw OR judul LIKE :kw";
$stmt = $pdo->prepare($query);
$stmt->execute(['kw' => "%$text%"]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($rows) {
    if (count($rows) > 1) {
        $jawaban = "Ditemukan beberapa informasi untuk <b>'$text'</b>:";
        $buttons = ['inline_keyboard' => []];
        foreach ($rows as $r) {
            $buttons['inline_keyboard'][] = [['text' => "📍 " . $r['judul'], 'callback_data' => $r['judul']]];
        }
        $buttons['inline_keyboard'][] = [['text' => '🏠 Kembali ke Menu', 'callback_data' => 'menu']];
        sendMessageTelegram($chat_id, $jawaban, json_encode($buttons));
    } else {
        $row = $rows[0];
        $header = strtoupper($row['kategori']);
        $jawaban = "<b>[$header]</b>\n<b>" . $row['judul'] . "</b>\n\n" . $row['konten'];
        $btnBack = json_encode(['inline_keyboard' => [[['text' => '🏠 Kembali ke Menu', 'callback_data' => 'menu']]]]);
        sendMessageTelegram($chat_id, $jawaban, $btnBack);
    }
} else {
    sendMessageTelegram($chat_id, "Maaf, informasi <b>'$text'</b> tidak ditemukan. Ketik <b>menu</b> untuk bantuan.");
}
?>
