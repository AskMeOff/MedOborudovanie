<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}

    $countPatient = $_POST['countPatient'];
    $countResearch = $_POST['countResearch'];
    $idUseEfficiency = $_POST['idUseEfficiency'];
    $data_year_efficiency = $_POST['data_year_efficiency'];
    $data_month_efficiency = $_POST['data_month_efficiency'];
$sql = "UPDATE use_efficiency
        SET count_patient = '$countPatient',
            count_research = '$countResearch',
            data_year_efficiency = '$data_year_efficiency',
            data_month_efficiency = '$data_month_efficiency'
        WHERE id_use_efficiency = '$idUseEfficiency'";
    $result = $connectionDB->executeQuery($sql);
    echo "Запись обновлена.";


