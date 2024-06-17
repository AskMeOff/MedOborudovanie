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
    $id_oborudovanie = $_POST['id_oborudovanie'];

    $sql = "INSERT INTO faults (date_fault, date_call_service, reason_fault, date_procedure_purchase, cost_repair, time_repair,id_oborudovanie)
            VALUES ('$date_fault', '$date_call_service', '$reason_fault', '$date_procedure_purchase', '$cost_repair', '$time_repair','$id_oborudovanie')";
    $result = $connectionDB->executeQuery($sql);
    echo "Запись добавлена.";


