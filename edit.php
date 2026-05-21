<?php
session_start();
require 'config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) exit('ID tidak ditemukan');

$stmt = $pdo->prepare("SELECT * FROM informasi_sekolah WHERE id = :id");
$stmt->execute([':id' => $id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) exit('Data tidak ditemukan');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kategori = $_POST['kategori'];
    $judul = $_POST['judul'];
    $konten = $_POST['konten'];

    $stmt = $pdo->prepare("UPDATE informasi_sekolah SET kategori=:kategori, judul=:judul, konten=:konten WHERE id=:id");
    $stmt->execute([
        ':kategori' => $kategori,
        ':judul' => $judul,
        ':konten' => $konten,
        ':id' => $id
    ]);

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Informasi</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-2xl mx-auto bg-white p-6 shadow-md rounded-lg">
    <h1 class="text-2xl font-bold mb-4">Edit Informasi Sekolah</h1>
    <form method="post">
        <label class="block mb-2">Kategori</label>
        <input type="text" name="kategori" value="<?= htmlspecialchars($row['kategori']) ?>" class="w-full mb-4 p-2 border rounded" required>

        <label class="block mb-2">Judul</label>
        <input type="text" name="judul" value="<?= htmlspecialchars($row['judul']) ?>" class="w-full mb-4 p-2 border rounded" required>

        <label class="block mb-2">Konten</label>
        <textarea name="konten" class="w-full mb-4 p-2 border rounded" rows="5" required><?= htmlspecialchars($row['konten']) ?></textarea>

        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Update</button>
        <a href="index.php" class="ml-2 text-gray-600 hover:underline">Batal</a>
    </form>
</div>

</body>
</html>