<?php
require 'config.php';
// require 'gemini.php'; // Baris ini bisa dihapus atau dinonaktifkan jika tidak digunakan lagi

// --- Ambil input dari WA (Fonnte) ---
$input = json_decode(file_get_contents("php://input"), true);

// Fonnte mengirimkan data dalam field 'message'
if (!isset($input['message'])) {
    exit;
}

$id_pengirim = preg_replace('/[^0-9]/', '', $input["sender"]);
$teks_pesan  = strtolower(trim($input["message"])); 

// Fungsi kirim pesan WA
function kirimPesan($target, $pesan, $token) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'target' => $target,
            'message' => $pesan,
        ),
        CURLOPT_HTTPHEADER => array(
            "Authorization: $token" 
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

// 1. Respon untuk /start
if ($teks_pesan === '/start') {
    $welcome = "Halo! Selamat Datang di Chatbot SMKN 1 Kutasari.\n\n" .
               "Ketik *menu* untuk melihat daftar informasi atau ketik langsung apa yang ingin Anda cari (Contoh: 'jadwal' atau 'tkj').";
    kirimPesan($id_pengirim, $welcome, WA_TOKEN); 
    exit;
}

// 2. Respon untuk menu
if ($teks_pesan === 'menu') {
    $menu = "*Daftar Informasi SMKN 1 Kutasari:*\n\n" .
            "🏫 *Profil* - Visi & Misi\n" .
            "🛠 *Jurusan* - Program Keahlian\n" .
            "📅 *Jadwal* - Pelajaran per Kelas\n" .
            "📝 *Nilai* - Standar KKM\n" .
            "🏆 *Prestasi* - Penghargaan\n" .
            "📅 *Kegiatan* - Agenda Sekolah\n\n" .
            "Silakan ketik salah satu kata kunci di atas.";
    kirimPesan($id_pengirim, $menu, WA_TOKEN);
    exit;
}

// --- KONEKSI DATABASE ---
try {
    $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit;
}

// --- PENCARIAN DATA (Fuzzy Search) ---
$stmt = $pdo->prepare("SELECT kategori, judul, konten FROM informasi_sekolah WHERE judul LIKE :kw OR kategori LIKE :kw");
$stmt->execute(['kw' => "%$teks_pesan%"]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($rows) {
    if (count($rows) > 1) {
        // JIKA BANYAK HASIL: Tampilkan daftar judul saja agar ringkas
        $reply = "Ditemukan beberapa informasi untuk *'$teks_pesan'*. Ketik judul spesifik yang ingin dilihat:\n\n";
        foreach ($rows as $row) {
            $reply .= "📍 *" . $row['judul'] . "*\n";
        }
    } else {
        // JIKA HANYA SATU HASIL: Tampilkan konten lengkap
        $row = $rows[0];
        $reply = "*[" . strtoupper($row['kategori']) . "]*\n";
        $reply .= "*" . $row['judul'] . "*\n\n" . $row['konten'];
    }
} else {
    $reply = "Maaf, informasi tentang *'$teks_pesan'* tidak ditemukan. Ketik *menu* untuk bantuan.";
}

// KIRIM PESAN AKHIR (Ringkasan AI dihapus agar pesan tetap singkat)
kirimPesan($id_pengirim, $reply, WA_TOKEN);
exit;