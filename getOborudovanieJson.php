<?php include 'connection/connection.php';

$url = "https://rceth.by/ru/JSONGetReestrMT";
set_time_limit(180); // Увеличиваем лимит времени выполнения
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Возвращать ответ как строку
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Отключение проверки SSL
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // Таймаут подключения
curl_setopt($ch, CURLOPT_TIMEOUT, 180); // Таймаут выполнения
$response = curl_exec($ch);
if (curl_errno($ch)) {
echo 'Ошибка cURL: ' . curl_error($ch);
curl_close($ch);
exit;
}
curl_close($ch);

// Декодирование JSON-ответа
$data = json_decode($response, true);

// Удаление всех записей из таблицы reestr
$deleteSql = "DELETE FROM reestr";
if ($connectionDB->con->query($deleteSql) === TRUE) {
echo "успешно удалена";
} else {
echo "Ошибка при удалении записей: " . $connectionDB->con->error;
}

// Подготовка SQL-запроса
$sql = "INSERT INTO reestr (Наименование, Производитель, Рег_номер_товара, Рег_номер_РУ, Тип, N_п_п) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $connectionDB->con->prepare($sql);

// Вставка данных в таблицу
foreach ($data as $item) {
// Проверка наличия всех необходимых ключей
if (isset($item['Наименование'], $item['Производитель'], $item['Рег_номер_товара'], $item['Рег_номер_РУ'], $item['Тип'], $item['N_п_п'])) {
$stmt->bind_param("ssssss",
$item['Наименование'],
$item['Производитель'],
$item['Рег_номер_товара'],
$item['Рег_номер_РУ'],
$item['Тип'],
$item['N_п_п']
);
$stmt->execute();
    echo "добавлена " . $item['N_п_п'];

} else {
// Логирование или обработка случая, когда ключи отсутствуют
error_log("Отсутствуют необходимые данные для элемента: " . json_encode($item));
}
}

// Закрытие подготовленного выражения
$stmt->close();

//header("Content-Type: application/json");
//echo $response;