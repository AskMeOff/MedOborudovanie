<?php
include "../../connection/connection.php";

ini_set('memory_limit', '1056M');


$url = "https://rceth.by/ru/JSONGetReestrMT";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Возвращать ответ как строку

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Ошибка cURL: ' . curl_error($ch);
    curl_close($ch);
    exit;
}

curl_close($ch);

// Декодирование JSON-ответа
//$data = json_decode($response, true);


//header("Content-Type: application/json");
echo $response;