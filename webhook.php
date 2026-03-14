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
file_put_contents("log.txt", $input.PHP_EOL, FILE_APPEND);

echo "EVENT_RECEIVED";

?>
