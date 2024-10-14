<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}

$date_fault = !empty($_POST['date_fault']) ? "'" . $_POST['date_fault'] . "'" : "NULL";
$date_call_service = !empty($_POST['date_call_service']) ? "'" . $_POST['date_call_service'] . "'" : "NULL";
$reason_fault = $_POST['reason_fault'];
$date_procedure_purchase = !empty($_POST['date_procedure_purchase']) ? "'" . $_POST['date_procedure_purchase'] . "'" : "NULL";
$date_dogovora = !empty($_POST['date_dogovora']) ? "'" . $_POST['date_dogovora'] . "'" : "NULL";
$time_repair = !empty($_POST['time_repair']) ? "'" . $_POST['time_repair'] . "'" : "NULL";
$cost_repair = $_POST['cost_repair'];
$remont = $_POST['remont'];
$date_remont = !empty($_POST['date_remont']) ? "'" . $_POST['date_remont'] . "'" : "NULL";
$edit_remontOrg = $_POST['edit_remontOrg'];
$id_fault = $_POST['id_fault'];

$sql = "UPDATE faults
        SET date_fault = $date_fault,
            date_call_service = $date_call_service,
            reason_fault = '$reason_fault',
            date_procedure_purchase = $date_procedure_purchase,
            date_dogovora = $date_dogovora,
            cost_repair = '$cost_repair',
            time_repair = $time_repair,
            remont = '$remont',
            date_remont = $date_remont,
            remontOrg = '$edit_remontOrg'
        WHERE id_fault = '$id_fault'";
    $result = $connectionDB->executeQuery($sql);
    echo "Запись обновлена.";


