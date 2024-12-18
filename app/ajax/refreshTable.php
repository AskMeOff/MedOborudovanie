<?php
include "../../connection/connection.php";
$id_org = $_GET['id_org'];


$sql = "SELECT o.*, type_oborudovanie.name, s.name as servname FROM oborudovanie o
        left outer join type_oborudovanie on o.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
        left outer join uz on o.id_uz = uz.id_uz
        left outer join servicemans s on s.id_serviceman = o.id_serviceman
        where uz.id_uz = '$id_org' and status in (0,1,3)
        ";
$result = $connectionDB->executeQuery($sql);

if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $serial_number = $row['serial_number'];
        $zavod_nomer = $row['zavod_nomer'];
        $nameOborudov = $row['name'];
        $mark1 = empty($serial_number) || $serial_number === 'Нет данных' || empty($nameOborudov) ? '<span style="color: red; font-size: 20px;">!</span>' : '';

        $data[] = array(
            'mark1' => $mark1
        ,'name' => $row['name'] ?? "Нет данных"
        , 'model' => $row['model'] ?? "Нет данных"
        , 'serial_number' => $row['serial_number'] ?? ""
        , 'zavod_nomer' => $row['zavod_nomer'] ?? ""
        , 'date_create' => $row['date_create'] ?? "Нет данных"
        , 'date_postavki' => $row['date_postavki'] ?? "Нет данных"
        , 'date_release' => $row['date_release'] ?? "Нет данных"
        , 'date_dogovora' => $row['date_dogovora'] ?? "Нет данных"
        , 'service_organization' => $row['servname'] ?? "Нет данных"
        , 'date_last_TO' => $row['date_last_TO'] ?? "Нет данных"
        , 'status' => $row['status'] ?? "Нет данных"
        , 'id_oborudovanie' => $row['id_oborudovanie'] ?? "Нет данных"

        );
    }
    echo json_encode($data);
} else {
    echo json_encode(array('empty' => true));
}
?>