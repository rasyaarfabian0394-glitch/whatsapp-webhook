<?php

$token = "EAAO3ZCCEWa9MBSxZCL8ciWJXZCGDZAdDbKKyTCj8My3AukpqfhBdz3QTZCGyze9U0lWvfGMxcmFHmz3xjm0X8cdq4rUAyX65mMKQKXkqxOKErTuP9gr3Jd5AtygR9DzQuXw727YucQcbsmWnlgVFVZAAWwE0ZCp0aAEhpU0lnZBbgYFQZCbRveZAX4PMFnZC7qvNhnMvfc6YT94L9UoE3NTyUhi04ZAmxWH8x97mtiwutQ0ci7mSX4GHcaX1FIUgeVVfYBzXEdTOWbDH0UcGjDaozoQoPtZCSZCLq4ZBbpIH5P2";
$phone_number_id = "1306398302550925";

// Memuat daftar nomor dari file kontak.php (bukan .txt)
$numbers = require 'kontak.php';

// Pastikan $numbers adalah array yang valid
if (!is_array($numbers) || empty($numbers)) {
    die("Daftar kontak kosong atau file kontak.php tidak valid!");
}

foreach ($numbers as $to) {
    $to = trim($to);
    if (empty($to)) continue;

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
        "Authorization: Bearer " . $token,
        "Content-Type: application/json"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    echo "Kirim ke $to -> Response: $response <br>";
}

?>
