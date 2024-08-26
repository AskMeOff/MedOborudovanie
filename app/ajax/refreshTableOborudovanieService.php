<?php
include "../../connection/connection.php";
$id_serviceman = $_GET['id_serviceman'];

$sql = "SELECT ob.id_oborudovanie, uz.id_uz, uz.name, typ.name as typename, ob.date_dogovor_service, ob.srok_dogovor_service, ob.summa_dogovor_service, ob.type_work_dogovor_service FROM `servicemans` s
LEFT JOIN oborudovanie ob on s.id_serviceman = ob.id_serviceman
LEFT JOIN uz uz on uz.id_uz = ob.id_uz
LEFT JOIN type_oborudovanie typ on typ.id_type_oborudovanie = ob.id_type_oborudovanie
where s.id_serviceman = '$id_serviceman'
        ";
$result = $connectionDB->executeQuery($sql);

if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            'id_oborudovanie' => $row['id_oborudovanie']
        , 'id_uz' => $row['id_uz']
        , 'name' => $row['name']
        , 'typename' => $row['typename']
        , 'date_dogovor_service' => $row['date_dogovor_service']
        , 'srok_dogovor_service' => $row['srok_dogovor_service']
        , 'summa_dogovor_service' => $row['summa_dogovor_service']
        , 'type_work_dogovor_service' => $row['type_work_dogovor_service']
        );
    }
    echo json_encode($data);
} else {
    echo json_encode(array('empty' => true));
}
?>