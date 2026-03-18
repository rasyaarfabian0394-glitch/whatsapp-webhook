<?php

$verify_token = "hanastore_token";

// ================== VERIFIKASI WEBHOOK ==================
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $mode = $_GET['hub_mode'] ?? $_GET['hub.mode'] ?? '';
    $token_verify = $_GET['hub_verify_token'] ?? $_GET['hub.verify_token'] ?? '';
    $challenge = $_GET['hub_challenge'] ?? $_GET['hub.challenge'] ?? '';

    if ($mode === "subscribe" && $token_verify === $verify_token) {
        echo $challenge;
        exit;
    }
}

// ================== TERIMA DATA ==================
$input = file_get_contents("php://input");
$data = json_decode($input, true);

file_put_contents("log.txt", $input.PHP_EOL, FILE_APPEND);

// ================== AUTO REPLY ==================
$token = "EAALO9Azi2DoBQZCkTt0k2k7ds80mavfV8mz9WFsl0L0slecnCmVXAVbt9dQqoAJgxV7gYLHqYqVUTWx8OIk29ZC5P8thAAToZC9EbVrZCMGfk8Dt9uf8CYF6CwnELcumbdSeOpIjayCN1Okpfh2XoSwXldFDbBgJ5ZAydPj58TUnajlm6SQsaCZAlw2tma7O6YBQFRmnlSfUmdi9ivJHLt2BwMq9FLXZAwhXiFo0I48ZC1sZCSYAA4VnAArVZCedPGuAZBZCxzy2h6byZCr9rtZCIapAmfNhyNv6nRpe5V7QZDZD";
$phone_number_id = "1070675906121436";

if(isset($data['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'])){
    
    $message = $data['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
    $from = $data['entry'][0]['changes'][0]['value']['messages'][0]['from'];

    $message = strtolower($message);

if ($message == "halo") {
    $reply = "Halo 👋 Selamat datang di Hana Store\n\nSilakan pilih:\n1. Lihat Produk\n2. Harga\n3. Admin";
} 
elseif ($message == "1") {
    $reply = "📦 Produk kami:\n- BajuTagor\n- CelanaBagas\n- SepatuHanafi";
}
elseif ($message == "2") {
    $reply = "💰 Harga mulai dari 50jt ya kak 😊";
}
elseif ($message == "3") {
    $reply = "👤 Hubungi admin: 6282221653103";
}
else {
    $reply = "Ketik *Halo* untuk melihat menu 😊";
}

    $url = "https://graph.facebook.com/v18.0/$phone_number_id/messages";

    $data_post = [
        "messaging_product" => "whatsapp",
        "to" => $from,
        "type" => "text",
        "text" => [
            "body" => $reply
        ]
    ];

    $headers = [
        "Authorization: Bearer $token",
        "Content-Type: application/json"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_post));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);
file_put_contents("log.txt", "RESPONSE: ".$response.PHP_EOL, FILE_APPEND);
    
}

echo "EVENT_RECEIVED";
