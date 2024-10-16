<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}

$id_oborudovanie = $_GET['id_oborudovanie'];

// Запрос на получение id_type_oborudovanie
$sqlType = "SELECT id_type_oborudovanie FROM oborudovanie WHERE id_oborudovanie = '$id_oborudovanie'";
$resultType = $connectionDB->executeQuery($sqlType);
$id_type_oborudovanie = null;

if ($resultType->num_rows > 0) {
    $rowType = $resultType->fetch_assoc();
    $id_type_oborudovanie = $rowType['id_type_oborudovanie'];
}

// Запрос на получение данных об эффективности
$sql = "SELECT * FROM use_efficiency WHERE id_oborudovanie = '$id_oborudovanie'";
$result = $connectionDB->executeQuery($sql);

// Если есть данные в таблице use_efficiency
if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            'count_research' => $row['count_research'],
            'count_patient' => $row['count_patient'],
            'id_use_efficiency' => $row['id_use_efficiency'],
            'data_year_efficiency' => $row['data_year_efficiency'],
            'data_month_efficiency' => $row['data_month_efficiency'],
            'id_type_oborudovanie' => $id_type_oborudovanie // Добавляем id_type_oborudovanie
        );
    }
    echo json_encode($data);

// Если нет данных в таблице use_efficiency
} else {
    echo json_encode(array('empty' => true, 'id_type_oborudovanie' => $id_type_oborudovanie));
}
?>
