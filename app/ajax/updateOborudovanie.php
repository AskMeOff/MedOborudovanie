<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}
$id_oborudovanie = $_POST['id_oborudovanie'];
$id_type_oborudovanie = $_POST['id_type_oborudovanie'];
$cost = $_POST['cost'];
$date_create = $_POST['date_create'];
$date_release = $_POST['date_release'];
$service_organization = $_POST['service_organization'];
$date_last_TO = $_POST['date_last_TO'];
$status = $_POST['status'];

    $sql = "update oborudovanie set id_type_oborudovanie = '$id_type_oborudovanie', cost = '$cost', date_create = '$date_create', date_release = '$date_release',
                        service_organization = '$service_organization', date_last_TO = '$date_last_TO', status = '$status' where id_oborudovanie = '$id_oborudovanie'";
    try {
        $result = $connectionDB->executeQuery($sql);
        echo "1";
    }catch(Exception $e){
        echo $e;
    }

