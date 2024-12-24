<?php

include 'connection/connection.php';




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
$data = json_decode($response, true);

$deleteSql = "DELETE FROM reestr";
$connectionDB->con->exec($deleteSql);

// Подготовка SQL-запроса
$sql = "INSERT INTO reestr (Наименование, Производитель, Рег_номер_товара, Рег_номер_РУ, Тип, N_п_п) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $connectionDB->con->prepare($sql);

// Вставка данных в таблицу
foreach ($data as $item) {
    // Проверка наличия всех необходимых ключей
    if (isset($item['Наименование'], $item['Производитель'], $item['Рег_номер_товара'], $item['Рег_номер_РУ'], $item['Тип'], $item['N_п_п'])) {
        $stmt->execute([
            $item['Наименование'],
            $item['Производитель'],
            $item['Рег_номер_товара'],
            $item['Рег_номер_РУ'],
            $item['Тип'],
            $item['N_п_п']
        ]);
    } else {
        // Логирование или обработка случая, когда ключи отсутствуют
        error_log("Отсутствуют необходимые данные для элемента: " . json_encode($item));
    }
}


//header("Content-Type: application/json");
echo $response;
