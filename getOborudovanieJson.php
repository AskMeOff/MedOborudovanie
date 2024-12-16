<?php

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

header("Content-Type: application/json");
echo $response;
