<?php
session_start();
require 'config.php';

// Jika sudah login, langsung lempar ke index
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        try {
            // Mengambil data admin berdasarkan username
            $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = :username LIMIT 1");
            $stmt->execute([':username' => $username]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin) {
                /* 
                   LOGIKA VERIFIKASI:
                   1. Mencoba verifikasi dengan password_verify (untuk format Hash)
                   2. Jika gagal, mencoba verifikasi teks biasa (untuk input manual di phpMyAdmin)
                */
                if (password_verify($password, $admin['password']) || $password === $admin['password']) {
                    
                    // Regenerate session ID untuk keamanan
                    session_regenerate_id();
                    
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_username'] = $admin['username'];
                    
                    header("Location: index.php");
                    exit;
                } else {
                    $error = "Password yang Anda masukkan salah.";
                }
            } else {
                $error = "Username tidak ditemukan.";
            }
        } catch (PDOException $e) {
            $error = "Terjadi kesalahan database: " . $e->getMessage();
        }
    } else {
        $error = "Harap isi username dan password.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - SMK Negeri 1 Kutasari</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #f3f4f6; }
    </style>
</head>
<body class="flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800">Login Admin</h1>
            <p class="text-gray-500 text-sm">Panel Kontrol Chatbot Sekolah</p>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-6" role="alert">
                <p class="font-bold">Gagal!</p>
                <p><?= htmlspecialchars($error) ?></p>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="mb-5">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Username</label>
                <input type="text" name="username" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" 
                       placeholder="Masukkan username" required autofocus>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
                <input type="password" name="password" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" 
                       placeholder="Masukkan password" required>
            </div>

            <button type="submit" 
                    class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:shadow-outline transform transition hover:scale-[1.02] active:scale-[0.98]">
                Masuk ke Panel
            </button>
        </form>
        
        <div class="mt-8 text-center">
            <p class="text-xs text-gray-400">&copy; 2026 IT SMKN 1 Kutasari. All rights reserved.</p>
        </div>
    </div>
</body>
</html>