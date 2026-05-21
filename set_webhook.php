<?php
$token = "8749239208:AAFyJIvjIhGT9VpEW65nDtyLjSAwXa2YHao";
$domain_railway = "https://chatbot-production-36c8.up.railway.app";
$webhook_url = $domain_railway . "/webhook.php";

$api_url = "https://api.telegram.org/bot$token/setWebhook?url=$webhook_url";
$response = file_get_contents($api_url);

echo "<h1>Setting Webhook Chatbot</h1>";
echo "Target URL: " . $webhook_url . "<br>";
echo "Response dari Telegram: " . $response;
?>
