<?php
include "../../connection/connection.php";
header('Content-Type: application/json');
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $sql = "SELECT * FROM oborudovanie WHERE id_oborudovanie = $id";
    $result = $connectionDB->executeQuery($sql);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        // Подготовка данных для вставки
        $id_type_oborudovanie = $row['id_type_oborudovanie'];
        $date_create = $row['date_create'];
        $date_postavki = $row['date_postavki'];
        $date_release = $row['date_release'];
        $model_prozvoditel = $row['model'];
        $service_organization = $row['id_serviceman'];
        $date_last_TO = $row['date_last_TO'];
        $status = $row['status'];
        $id_org = $row['id_uz'];
        $insertSql = "INSERT INTO oborudovanie (id_type_oborudovanie, date_create, date_postavki, date_release, model, id_serviceman, date_last_TO, status, id_uz) 
                      VALUES ('$id_type_oborudovanie', '$date_create', '$date_postavki', '$date_release', '$model_prozvoditel', '$service_organization', '$date_last_TO', '$status', '$id_org')";

        // Логирование SQL-запроса
        error_log("Insert SQL: $insertSql");

        if ($connectionDB->executeQuery($insertSql)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Не удалось вставить запись.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Запись не найдена.']);
    }
}
?>


