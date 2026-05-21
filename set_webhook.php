<?php
$token = "8749239208:AAFyJIvjIhGT9VpEW65nDtyLjSAwXa2YHao";
// Ganti dengan domain Railway yang sudah kamu generate tadi
$webhook_url = "https://chatbot-production-36c8.up.railway.app/webhook.php";

$response = file_get_contents("https://api.telegram.org/bot$token/setWebhook?url=$webhook_url");
echo $response;
?>
