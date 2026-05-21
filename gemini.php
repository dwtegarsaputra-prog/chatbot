<?php
require 'config.php';

if (!defined('GEMINI_API_KEY')) define('GEMINI_API_KEY', 'AIzaSyCkekIrRZTuXueFBXC1pSD7qd8BtldY2S4');

// Ambil informasi sekolah dari database
function get_informasi_sekolah($pdo) {
    $stmt = $pdo->query("SELECT kategori, judul, konten FROM informasi_sekolah");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $info_text = "";
    foreach ($rows as $row) {
        $info_text .= strtoupper($row['kategori']) . ": " . $row['judul'] . " - " . $row['konten'] . "\n";
    }
    return $info_text;
}

// Fungsi utama untuk proses prompt ke Gemini dengan system prompt
function proses_gemini($user_prompt, $pdo) {
    $info_sekolah = get_informasi_sekolah($pdo);

    $system_prompt = "Kamu adalah asisten virtual sekolah. Fokuslah menjawab pertanyaan berdasarkan informasi sekolah yang tersedia. " .
                     "Jika pertanyaan di luar data sekolah, jawab dengan sopan bahwa informasi tidak tersedia.\n\n" .
                     "Berikut data sekolah:\n" . $info_sekolah;

    $full_prompt = $system_prompt . "\nPertanyaan: " . $user_prompt;

    $api_url = 'https://generativeai.googleapis.com/v1beta2/models/gemini-1.5:generateText?key=' . GEMINI_API_KEY;

    $data = [
        "prompt" => $full_prompt,
        "temperature" => 0.7,
        "maxOutputTokens" => 300
    ];

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    $res = json_decode($response, true);

    // Jika Gemini gagal, fallback ke hasil query
    if (!$res || !isset($res['candidates'][0]['output'])) {
        return $info_sekolah;
    }

    return $res['candidates'][0]['output'];
}
?>