<?php
include "../../connection/connection.php";

if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}

$date_fault = $_POST['date_fault'] ?? null;
$date_call_service = $_POST['date_call_service'] ?? null;
$reason_fault = $_POST['reason_fault'] ?? null;
$date_procedure_purchase = $_POST['date_procedure_purchase'] ?? null;
$cost_repair = $_POST['cost_repair'] ?? null;
$time_repair = $_POST['time_repair'] ?? null;
$add_remontOrg = $_POST['add_remontOrg'] ?? null;
$id_oborudovanie = $_POST['id_oborudovanie'] ?? null;

$cost_repair = !empty($cost_repair) ? "'" . $cost_repair . "'" : 0;
$date_fault = !empty($date_fault) ? "'" . $date_fault . "'" : "NULL";
$date_call_service = !empty($date_call_service) ? "'" . $date_call_service . "'" : "NULL";
$date_procedure_purchase = !empty($date_procedure_purchase) ? "'" . $date_procedure_purchase . "'" : "NULL";
$time_repair = !empty($time_repair) ? "'" . $time_repair . "'" : "NULL";

$documentsDir = '../documents/' . $id_oborudovanie . '/';
if (!file_exists($documentsDir)) {
    mkdir($documentsDir, 0777, true);
}

$file_name = null;
if (isset($_FILES['fileReport']) && $_FILES['fileReport']['error'] === UPLOAD_ERR_OK) {
    $file_name = basename($_FILES['fileReport']['name']);
    $file_tmp = $_FILES['fileReport']['tmp_name'];
    move_uploaded_file($file_tmp, $documentsDir . $file_name);
}

$sql = "INSERT INTO faults (date_fault, date_call_service, reason_fault, date_procedure_purchase, cost_repair, time_repair, remontOrg, id_oborudovanie, documentOrg)
        VALUES ($date_fault, $date_call_service, '$reason_fault', $date_procedure_purchase, $cost_repair, $time_repair, '$add_remontOrg', '$id_oborudovanie', '$file_name')";

$result = $connectionDB->executeQuery($sql);
if ($result) {
    echo "Запись добавлена.";
} else {
    echo "Ошибка: " . mysqli_error($connectionDB);
}

?>