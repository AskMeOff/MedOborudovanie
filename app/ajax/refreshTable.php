<?php
include "../../connection/connection.php";
$id_org = $_GET['id_org'];

$sql = "SELECT o.*, type_oborudovanie.name, s.name as servname FROM oborudovanie o
        left outer join type_oborudovanie on o.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
        left outer join uz on o.id_uz = uz.id_uz
        left outer join servicemans s on s.id_serviceman = o.id_serviceman
        where uz.id_uz = '$id_org'
        ";
$result = $connectionDB->executeQuery($sql);

if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            'name' => $row['name'] ?? "Нет данных"
        , 'cost' => $row['cost'] ?? "Нет данных"
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