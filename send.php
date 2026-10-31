<?php

$token = "EAAO3ZCCEWa9MBS2kM22Pl1VQZB0NbZB08Bow6x0B1GjWSUChWkJhMLBldYrnessFwoySreMsqljHpEYMTJaZAcfFyDw6rywI0g1g1YAKZAzUDVvvECjI4tcxU6a8QleZBDgZAAIZCMuQa4XwUc23FwHmHNZCtmLhFX68mNwCimbImcEdV0tUQAyrlVHHKzDVaxbz0AkY1FXxZBNC3bLaZCHkZA65vSZBoFkxSRIwHoKHPWlTNHIUmvxyTyDuOxadLBDWdIJO12kV7QggBZAqKwDAB5F7euoVryKWUjeBybfgZDZD";
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
