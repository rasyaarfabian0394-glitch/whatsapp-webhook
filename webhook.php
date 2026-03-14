<?php

$verify_token = "hanastore_token";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $mode = $_GET['hub.mode'] ?? '';
    $token = $_GET['hub.verify_token'] ?? '';
    $challenge = $_GET['hub.challenge'] ?? '';

    if ($mode === "subscribe" && $token === $verify_token) {
        echo $challenge;
        exit;
    }
}

$input = file_get_contents("php://input");
$data = json_decode($input, true);

file_put_contents("log.txt", $input.PHP_EOL, FILE_APPEND);

if(isset($data['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'])){
    
    $message = $data['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
    $from = $data['entry'][0]['changes'][0]['value']['messages'][0]['from'];

    file_put_contents("log.txt", "Pesan dari $from : $message".PHP_EOL, FILE_APPEND);
}

echo "EVENT_RECEIVED";
