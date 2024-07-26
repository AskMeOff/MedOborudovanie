<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}

$id_type_oborudovanie = $_POST['id_type_oborudovanie'];
//$cost = $_POST['cost'];
if (isset($_POST['date_create']))
    $date_create = $_POST['date_create'];
else
    $date_create = "NULL";
if (isset($_POST['date_create']))
    $date_postavki = $_POST['date_postavki'];
else
    $date_postavki = "NULL";
if (isset($_POST['date_create']))
    $date_release = $_POST['date_release'];
else
    $date_release = "NULL";
if (isset($_POST['date_create']))
    $date_dogovora = $_POST['date_dogovora'];
else
    $date_dogovora = "NULL";
if (isset($_POST['date_create']))
    $service_organization = $_POST['service_organization'];
else
    $service_organization = "NULL";
if (isset($_POST['date_create']))
    $date_last_TO = $_POST['date_last_TO'];
else
    $date_last_TO = "NULL";
$status = $_POST['status'];
$id_org = $_POST['id_org'];

$sql = "insert into oborudovanie (id_type_oborudovanie, date_create, date_postavki, date_release, date_dogovora, service_organization, date_last_TO, status, id_uz)
                values('$id_type_oborudovanie'  , '$date_create', '$date_postavki' , '$date_release', '$date_dogovora',
                        '$service_organization' , '$date_last_TO' , '$status', '$id_org')";
try {
    $result = $connectionDB->executeQuery($sql);
    echo "1";
} catch (Exception $e) {
    echo $e;
}

