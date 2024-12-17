<?php
include "../../connection/connection.php";

if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT DISTINCT tfbd.id_oborudovanie, uz.name as uz_name, `to`.name as type_name, s.name as serv_name FROM table_faults_by_date tfbd 
    LEFT JOIN oborudovanie o ON tfbd.id_oborudovanie = o.id_oborudovanie
    LEFT JOIN uz uz ON o.id_uz = uz.id_uz
    LEFT JOIN type_oborudovanie `to` ON o.id_type_oborudovanie = `to`.id_type_oborudovanie
    LEFT JOIN servicemans s ON o.id_serviceman = s.id_serviceman";

$result = $connectionDB->executeQuery($sql);

$data = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($data);
?>