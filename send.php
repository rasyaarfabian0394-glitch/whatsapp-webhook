<?php

$token = "EAAO3ZCCEWa9MBSwsSIOnqHYFabwS0jc0oaUxnPZChtuw3csnlPnjMiAZAcZCEHo8jhqNciQZC7xzrgZAndKfHIK4Ai1IMU1xSsbZCIAaZCmB8CMWNcRTXsgshuuLqBGOkyIjemuLv81XFXt7744wv1UKIO2L0r9xqgktK1GM0N3SCCFfiYoDEZCbbif48rpKuKPGhtBxq8jnurUbEnQy6L5Y6imZA9CJNUQinUCNOSIfnh2lVugKvWrpRmMysiZAXdf7qVxJfHjzn7vymWOGcbddPSzZCjBajWThAURa5mkZD";
$phone_number_id = "1306398302550925";

$numbers = file('kontak.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$message = "Halo 👋 ini pesan promosi dari website saya.";

foreach ($numbers as $to) {

$url = "https://graph.facebook.com/v21.0/$phone_number_id/messages";

$data = [
    "messaging_product" => "whatsapp",
    "to" => $to,
    "type" => "template",
    "template" => [
        "name" => "dui_store",
        "language" => [
            "code" => "id"
        ]
    ]
];

$headers = [
"Authorization: Bearer" . $token,
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
