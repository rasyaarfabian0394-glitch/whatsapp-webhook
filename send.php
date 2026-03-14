<?php

$token = "ACCESS_TOKEN_KAMU";
$phone_number_id = "1070675906121436";

$numbers = [
"6282221653103",
"6281373735966",
"628388623137"
];

$message = "Halo 👋 ini pesan promosi dari website saya.";

foreach ($numbers as $to) {

$url = "https://graph.facebook.com/v18.0/$phone_number_id/messages";

$data = [
    "messaging_product" => "whatsapp",
    "to" => $to,
    "type" => "text",
    "text" => [
        "body" => $message
    ]
];

$headers = [
"Authorization: Bearer $token",
"Content-Type: application/json"
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

echo $response;
}

?>
