<?php
include_once 'config.php';
// Function to perform Base64 URL encoding
function base64UrlEncode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

// Function to create a JWT token
function createJWT($payload, $secret) {
    // Define the header
    $header = ['alg' => 'HS256', 'typ' => 'JWT'];
    
    // JSON encode header and payload
    $headerJSON = json_encode($header);
    $payloadJSON = json_encode($payload);
    
    // Base64 URL encode header and payload
    $headerEncoded = base64UrlEncode($headerJSON);
    $payloadEncoded = base64UrlEncode($payloadJSON);
    
    // Create signature using HMAC SHA-256
    $signature = hash_hmac('sha256', "$headerEncoded.$payloadEncoded", $secret, true);
    $signatureEncoded = base64UrlEncode($signature);
    
    // Return the JWT token
    return "$headerEncoded.$payloadEncoded.$signatureEncoded";
}

function sendUser(string $orderId, string $amount) {
    global $secretKey;
    global $paymentGatewayUrl;
    if (!isset($orderId) || !isset($amount))
        return null;
    // Sample secret key and payload
    $orderId = "tiche-".sprintf("%06d", $orderId);
    $payload = [
        "order"  => $orderId,
        "amount" => $amount
    ];
    // Generate the JWT token
    $token = createJWT($payload, $secretKey);
    return "$paymentGatewayUrl?order=$token";
}

function checkStatus(string $orderId) {
    global $accessKey;
    global $paymentStatusUrl;

    if (is_numeric($orderId)) {
        $orderId = "tiche-".sprintf("%06d", $orderId);
    }

    $host = "$paymentStatusUrl?order=$orderId";
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $host,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array(
            "_token: " . $accessKey
        ),
    ));

    $response = curl_exec($curl);
    $paid = false;
    if (curl_errno($curl)) {
        echo 'Curl error: ' . curl_error($curl);
    } else {
        $response = json_decode($response, true);
        if ($response['data']['status'] == "PAID") {
            $paid = true;
        }
    }

    curl_close($curl);
    return $paid;
}

?>
