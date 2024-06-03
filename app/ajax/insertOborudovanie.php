<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}

$id_type_oborudovanie = $_POST['id_type_oborudovanie'];
$cost = $_POST['cost'];
$date_create = $_POST['date_create'];
$date_release = $_POST['date_release'];
$service_organization = $_POST['service_organization'];
$date_last_TO = $_POST['date_last_TO'];
$status = $_POST['status'];
$id_org = $_POST['id_org'];

    $sql = "insert into oborudovanie (id_type_oborudovanie, cost, date_create, date_release, service_organization, date_last_TO, status, id_uz)
                values('$id_type_oborudovanie' , '$cost' , '$date_create' , '$date_release',
                        '$service_organization' , '$date_last_TO' , '$status', '$id_org')";
    try {
        $result = $connectionDB->executeQuery($sql);
        echo "1";
    }catch(Exception $e){
        echo $e;
    }

