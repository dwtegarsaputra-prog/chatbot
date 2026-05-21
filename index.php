<?php
session_start();
require 'config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Ambil semua data
$stmt = $pdo->query("SELECT * FROM informasi_sekolah ORDER BY id DESC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Informasi Sekolah</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Admin Informasi Sekolah</h1>
        <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</a>
    </div>
    
    <a href="tambah.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">+ Tambah Informasi</a>

    <div class="overflow-x-auto">
    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 text-left">ID</th>
                <th class="px-4 py-2 text-left">Kategori</th>
                <th class="px-4 py-2 text-left">Judul</th>
                <th class="px-4 py-2 text-left">Konten</th>
                <th class="px-4 py-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $row): ?>
            <tr class="border-b">
                <td class="px-4 py-2"><?= $row['id'] ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($row['kategori']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($row['judul']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($row['konten']) ?></td>
                <td class="px-4 py-2 text-center">
                    <a href="edit.php?id=<?= $row['id'] ?>" class="text-yellow-500 hover:text-yellow-700 mr-2">Edit</a>
                    <a href="hapus.php?id=<?= $row['id'] ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>

</body>
</html>