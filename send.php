<?php

$token = "EAALO9Azi2DoBQZCkTt0k2k7ds80mavfV8mz9WFsl0L0slecnCmVXAVbt9dQqoAJgxV7gYLHqYqVUTWx8OIk29ZC5P8thAAToZC9EbVrZCMGfk8Dt9uf8CYF6CwnELcumbdSeOpIjayCN1Okpfh2XoSwXldFDbBgJ5ZAydPj58TUnajlm6SQsaCZAlw2tma7O6YBQFRmnlSfUmdi9ivJHLt2BwMq9FLXZAwhXiFo0I48ZC1sZCSYAA4VnAArVZCedPGuAZBZCxzy2h6byZCr9rtZCIapAmfNhyNv6nRpe5V7QZDZD";
$phone_number_id = "1070675906121436";

$numbers = [
"6282221653103",
"6285143296561",
"628388623137"   
];

$message = "Halo 👋 ini pesan promosi dari website saya.";

foreach ($numbers as $to) {

$url = "https://graph.facebook.com/v18.0/$phone_number_id/messages";

$data = [
    "messaging_product" => "whatsapp",
    "to" => $to,
    "type" => "template",
    "template" => [
        "name" => "promo_hana",
        "language" => [
            "code" => "id"
        ]
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
