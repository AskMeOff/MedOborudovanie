<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}
$id_oborudovanie = $_POST['id_oborudovanie'];

if (isset($_POST['date_dogovor_service']))
    $date_dogovor_service = $_POST['date_dogovor_service'];
else
    $date_dogovor_service = "NULL";
if (isset($_POST['srok_dogovor_service']))
    $srok_dogovor_service = $_POST['srok_dogovor_service'];
else
    $srok_dogovor_service = "NULL";
if (isset($_POST['summa_dogovor_service']))
    $summa_dogovor_service = $_POST['summa_dogovor_service'];
else
    $summa_dogovor_service = "NULL";

if (isset($_POST['type_work_dogovor_service']))
    $type_work_dogovor_service = $_POST['type_work_dogovor_service'];
else
    $type_work_dogovor_service = "NULL";


$sql = "update oborudovanie set date_dogovor_service = '$date_dogovor_service', srok_dogovor_service = '$srok_dogovor_service',
                        summa_dogovor_service = '$summa_dogovor_service',
                        type_work_dogovor_service = '$type_work_dogovor_service' 
                        where id_oborudovanie = '$id_oborudovanie'";
try {
    $result = $connectionDB->executeQuery($sql);
    echo "1";
}catch(Exception $e){
    echo $e;
}
