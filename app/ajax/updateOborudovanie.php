<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}

$id_oborudovanie = $_POST['id_oborudovanie'];
$id_type_oborudovanie = $_POST['id_type_oborudovanie'];
$date_create = isset($_POST['date_create']) && $_POST['date_create'] !== "" ? "'" . $connectionDB->escapeString($_POST['date_create']) . "'" : "NULL";
$date_postavki = isset($_POST['date_postavki']) && $_POST['date_postavki'] !== "" ? "'" . $connectionDB->escapeString($_POST['date_postavki']) . "'" : "NULL";
$date_release = isset($_POST['date_release']) && $_POST['date_release'] !== "" ? "'" . $connectionDB->escapeString($_POST['date_release']) . "'" : "NULL";
$model_prozvoditel = isset($_POST['model_prozvoditel']) && $_POST['model_prozvoditel'] !== "" ? "'" . $connectionDB->escapeString($_POST['model_prozvoditel']) . "'" : "NULL";
$service_organization = isset($_POST['service_organization']) && $_POST['service_organization'] !== "" ? "'" . $connectionDB->escapeString($_POST['service_organization']) . "'" : "NULL";
$date_last_TO = isset($_POST['date_last_TO']) && $_POST['date_last_TO'] !== "" ? "'" . $connectionDB->escapeString($_POST['date_last_TO']) . "'" : "NULL";
$status = (int)$_POST['status'];

$sql = "UPDATE oborudovanie SET 
            id_type_oborudovanie = '$id_type_oborudovanie', 
            date_create = $date_create, 
            date_postavki = $date_postavki,
            date_release = $date_release, 
            model = $model_prozvoditel,
            id_serviceman = $service_organization, 
            date_last_TO = $date_last_TO, 
            status = $status 
        WHERE id_oborudovanie = '$id_oborudovanie'";

try {
    $result = $connectionDB->executeQuery($sql);
    echo "1";
} catch(Exception $e) {
    echo $e->getMessage();
}

