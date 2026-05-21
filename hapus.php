<?php
session_start();
require 'config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM informasi_sekolah WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

header("Location: index.php");
exit;
?>