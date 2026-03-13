<?php

$verify_token = "hanastore_token";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $mode = $_GET['hub_mode'] ?? '';
    $token = $_GET['hub_verify_token'] ?? '';
    $challenge = $_GET['hub_challenge'] ?? '';

    if ($mode === "subscribe" && $token === $verify_token) {
        echo $challenge;
        exit;
    }
}

$input = file_get_contents("php://input");
file_put_contents("log.txt", $input.PHP_EOL, FILE_APPEND);

echo "EVENT_RECEIVED";

?>
