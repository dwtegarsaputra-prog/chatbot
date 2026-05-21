<?php
$token = "8749239208:AAFyJIvjIhGT9VpEW65nDtyLjSAwXa2YHao";
$webhook_url = "https://8ce3-2001-448a-40a0-177c-c1da-345f-7de8-7a64.ngrok-free.app/infosekolah/webhook.php";

$response = file_get_contents("https://api.telegram.org/bot$token/setWebhook?url=$webhook_url");
echo $response;
?>