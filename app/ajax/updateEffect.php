<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}

    $countPatient = $_POST['countPatient'];
    $countResearch = $_POST['countResearch'];
    $idUseEfficiency = $_POST['idUseEfficiency'];

$sql = "UPDATE use_efficiency
        SET count_patient = '$countPatient',
            count_research = '$countResearch'
        WHERE id_use_efficiency = '$idUseEfficiency'";
    $result = $connectionDB->executeQuery($sql);
    echo "Запись обновлена.";


