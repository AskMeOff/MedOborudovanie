<?php
require_once '../../connection/connection.php'; // подключение к БД

// Параметры пагинации
$limit = 50;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$start = ($page - 1) * $limit;

// Основной SQL-запрос (выбираем нужные поля)
$sql = "
    SELECT 
        oborudovanie.id_oborudovanie,
        oborudovanie.model,
        oborudovanie.serial_number,
        oborudovanie.zavod_nomer,
        oborudovanie.date_create,
        oborudovanie.date_postavki,
        oborudovanie.date_release,
        oborudovanie.date_last_TO,
        oborudovanie.status,
        type_oborudovanie.name as type_name,
        uz.name as poliklinika,
        s.name as servname
    FROM oborudovanie
    INNER JOIN uz ON oborudovanie.id_uz = uz.id_uz
    LEFT JOIN type_oborudovanie ON oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
    LEFT JOIN servicemans s ON s.id_serviceman = oborudovanie.id_serviceman
    WHERE oborudovanie.status IN (0, 1, 3)
    LIMIT $start, $limit";

$result = $connectionDB->executeQuery($sql);

$data = [];
function clean($value) {
    return $value !== null ? htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8') : '';
}
while ($row = mysqli_fetch_assoc($result)) {
    // Функция для безопасного htmlspecialchars с проверкой на null


    $mark1 = empty($row['serial_number']) || empty($row['type_name'])
        ? '<span style="color: red; font-size: 20px;">!</span>'
        : '';

    $status_html = match($row['status']) {
        '1' => '<div style="border-radius: 5px;background-color: green;color: white; padding: 5px;">исправно</div>',
        '3' => '<div style="border-radius: 5px;background-color: orange;color: white; padding: 5px;">Работа в ограниченном режиме</div>',
        default => '<div style="border-radius: 5px;background-color: red;color: white; padding: 5px; font-size: 11px;width: 85px;" onclick="getFaultsTable(' . clean($row['id_oborudovanie']) . ')">неисправно</div>',
    };

    $data[] = [
        'id' => clean($row['id_oborudovanie']),
        'mark' => $mark1,
        'poliklinika' => clean($row['poliklinika']),
        'model' => clean($row['model']),
        'serial_number' => clean($row['serial_number']),
        'zavod_nomer' => clean($row['zavod_nomer']),
        'type_name' => clean($row['type_name']),
        'date_create' => clean($row['date_create']),
        'date_postavki' => $row['date_postavki'] ? date('d.m.Y', strtotime($row['date_postavki'])) : 'Нет данных',
        'date_release' => $row['date_release'] ? date('d.m.Y', strtotime($row['date_release'])) : 'Нет данных',
        'servname' => clean($row['servname']),
        'date_last_TO' => $row['date_last_TO'] ? date('d.m.Y', strtotime($row['date_last_TO'])) : 'Нет данных',
        'status_html' => $status_html
    ];
}

// Запрос на общее количество записей
$sql_count = "SELECT COUNT(*) AS total FROM oborudovanie WHERE status IN (0, 1, 3)";
$result_count = $connectionDB->executeQuery($sql_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_records = $row_count['total'];
$total_pages = ceil($total_records / $limit);

// Возвращаем JSON
echo json_encode([
    'data' => $data,
    'total_pages' => $total_pages,
    'current_page' => $page
]);

exit;