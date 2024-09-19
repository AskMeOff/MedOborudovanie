<?php
include "../../connection/connection.php";
include "../classes/UsersList.php";

$id_uz = $usersList->getUser($_COOKIE['token'])->getIdUz();

$id_type_oborudovanie = $_POST['id_type_oborudovanie'];
$cost = isset($_POST['cost']) && $_POST['cost'] !== "" ? "'" . $connectionDB->escapeString($_POST['cost']) . "'" : "NULL";
$model = isset($_POST['model']) && $_POST['model'] !== "" ? "'" . $connectionDB->escapeString($_POST['model']) . "'" : "NULL";
$contract = isset($_POST['contract']) && $_POST['contract'] !== "" ? "'" . $connectionDB->escapeString($_POST['contract']) . "'" : "NULL";
$id_serviceman = $_POST['id_serviceman'];
$id_postavschik = $_POST['id_postavschik'];
$date_get_sklad = isset($_POST['date_get_sklad']) && $_POST['date_get_sklad'] !== "" ? "'" . $connectionDB->escapeString($_POST['date_get_sklad']) . "'" : "NULL";
$date_srok_vvoda = isset($_POST['date_srok_vvoda']) && $_POST['date_srok_vvoda'] !== "" ? "'" . $connectionDB->escapeString($_POST['date_srok_vvoda']) . "'" : "NULL";
$reasons = isset($_POST['reasons']) && $_POST['reasons'] !== "" ? "'" . $connectionDB->escapeString($_POST['reasons']) . "'" : "NULL";


$sql = "INSERT INTO oborudovanie (id_type_oborudovanie, cost, model, num_and_date, id_serviceman, id_postavschik, date_get_sklad, 
                          date_norm_srok_vvoda, reasons, id_uz, status)
        VALUES ('$id_type_oborudovanie', $cost, $model, $contract, $id_serviceman, $id_postavschik, $date_get_sklad, 
                $date_srok_vvoda, $reasons, $id_uz, 2)";

try {
    $result = $connectionDB->executeQuery($sql);
    echo "1";
} catch (Exception $e) {
    echo $e;
}
