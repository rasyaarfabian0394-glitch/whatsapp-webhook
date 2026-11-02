[02/11/2026 19.10] Hana Store One: <?php
// Token dan Konfigurasi
$token = "EAAO3ZCCEWa9MBSxUAeGmJZAbuFEUdccjWgoux3JvofZAbq4HEqnQ1pzxVd0N8UEL2thD1Fva9I4JFx6z2DsYRP5FpkZB9ENKmVxi3IWJGcyjpcynRqg7VggZAhF0yAPnBnPtadZBLMmZAFZBEM0lzViZCUZBNQZAwoFf9XaYFJR4zj5ULTlvFNoCamKzJaRmTI5Fhx71eA672H4lIgNeu79paXymbXJ8cQVeOJR7KW9ZAWNh7gxBwbGxsglk4p10l0eeCtVlQEXeYDnqdkImVc1abBTSu447ZAFFWx5Whs8BP";
$phone_number_id = "1306398302550925";

// Memuat daftar nomor dari file kontak.php
$numbers = require 'kontak.php';

if (!is_array($numbers) || empty($numbers)) {
    die("<div style='font-family:sans-serif; padding:20px; color:red;'><b>Error:</b> Daftar kontak kosong atau file kontak.php tidak valid!</div>");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Broadcast WhatsApp - Laporan Pengiriman</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f7f6; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 800px; margin: auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        h2 { color: #075e54; margin-top: 0; border-bottom: 2px solid #25d366; padding-bottom: 10px; }
        .log-item { padding: 12px 15px; margin-bottom: 10px; border-radius: 8px; font-size: 14px; border-left: 5px solid #ccc; background: #fafafa; }
        .success { border-left-color: #25d366; background: #e8f5e9; color: #1b5e20; }
        .error { border-left-color: #d32f2f; background: #ffebee; color: #c62828; }
        .summary { margin-top: 20px; padding: 15px; background: #e0f2f1; border-radius: 8px; font-weight: bold; color: #004d40; }
    </style>
</head>
<body>
<div class="container">
    <h2>🚀 Laporan Broadcast WhatsApp</h2>
    <p>Memproses pengiriman pesan template <b>promo_topup_game</b>...</p>
    <hr style="border:0; border-top:1px solid #eee; margin:20px 0;">

    <?php
    $success_count = 0;
    $failed_count = 0;

    foreach ($numbers as $index => $to) {
        $to = trim($to);
        if (empty($to)) continue;

        $url = "https://graph.facebook.com/v21.0/$phone_number_id/messages";

        // Struktur data dengan 3 parameter yang dibutuhkan oleh template promo_topup_game
        $data = [
            "messaging_product" => "whatsapp",
            "to" => $to,
            "type" => "template",
            "template" => [
                "name" => "promo_topup_game",
                "language" => [
                    "code" => "id"
                ],
                "components" => [
                    [
                        "type" => "body",
                        "parameters" => [
                            ["type" => "text", "text" => "IND0168"],       // Mengisi parameter {{1}}
                            ["type" => "text", "text" => "220722"],      // Mengisi parameter {{2}}
                            ["type" => "text", "text" => "https://bit.ly/npkindo168"] // Mengisi parameter {{3}}
                        ]
                    ]
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

        $res_json = json_decode($response, true);
        
        // Periksa apakah pesan berhasil dikirim
        if (isset($res_json['messages'])) {
            $success_count++;
            echo "<div class='log-item success'><b>[#".($index+1)."] Berhasil</b> dikirim ke nomor: <code>$to</code></div>";
        } else {
            $failed_count++;
            echo "<div class='log-item error'><b>[#".($index+1)."] Gagal</b> ke nomor <code>$to</code>. Detail: <pre style='margin:5px 0 0; white-space: pre-wrap;'>".htmlspecialchars($response)."</pre></div>";
        }
    }
    ?>
[02/11/2026 19.10] Hana Store One: <div class="summary">
        📊 Ringkasan: Berhasil terkirim: <?= $success_count ?> | Gagal: <?= $failed_count ?>
    </div>
</div>
</body>
</html>
