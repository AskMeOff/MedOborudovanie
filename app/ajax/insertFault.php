<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}

$date_fault = $_POST['date_fault'];
$date_call_service = $_POST['date_call_service'];
$reason_fault = $_POST['reason_fault'];
$date_procedure_purchase = $_POST['date_procedure_purchase'];
$cost_repair = $_POST['cost_repair'];
$time_repair = $_POST['time_repair'];
$add_remontOrg = $_POST['add_remontOrg'];
$id_oborudovanie = $_POST['id_oborudovanie'];
$cost_repair = !empty($cost_repair) ? "'" . $cost_repair . "'" : 0;
$date_fault = !empty($date_fault) ? "'" . $date_fault . "'" : "NULL";
$date_call_service = !empty($date_call_service) ? "'" . $date_call_service . "'" : "NULL";
$date_procedure_purchase = !empty($date_procedure_purchase) ? "'" . $date_procedure_purchase . "'" : "NULL";
$time_repair = !empty($time_repair) ? "'" . $time_repair . "'" : "NULL";


$sql = "INSERT INTO faults (date_fault, date_call_service, reason_fault, date_procedure_purchase, cost_repair, time_repair, remontOrg, id_oborudovanie)
        VALUES ($date_fault, $date_call_service, '$reason_fault', $date_procedure_purchase, '$cost_repair', $time_repair, '$add_remontOrg', '$id_oborudovanie')";

$result = $connectionDB->executeQuery($sql);
if ($result) {
    echo "Запись добавлена.";
} else {
    echo "Ошибка: " . mysqli_error($connectionDB);
}