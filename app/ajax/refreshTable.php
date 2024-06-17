<?php
include "../../connection/connection.php";
$id_org = $_GET['id_org'];

$sql = "SELECT oborudovanie.*, type_oborudovanie.name FROM oborudovanie
        left outer join type_oborudovanie on oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
        left outer join uz on oborudovanie.id_uz = uz.id_uz
        where uz.id_uz = '$id_org'
        ";
$result = $connectionDB->executeQuery($sql);

if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            'name' => $row['name']
        , 'cost' => $row['cost']
        , 'date_create' => $row['date_create']
        , 'date_release' => $row['date_release']
        , 'service_organization' => $row['service_organization']
        , 'date_last_TO' => $row['date_last_TO']
        , 'status' => $row['status']
        , 'id_oborudovanie' => $row['id_oborudovanie']

        );
    }
    echo json_encode($data);
} else {
    echo json_encode(array('empty' => true));
}
?>