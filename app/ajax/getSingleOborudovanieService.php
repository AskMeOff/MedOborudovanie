<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}
$id_oborudovanie = $_GET['id_oborudovanie'];
$sql = "SELECT oborudovanie.*, uz.name as uz, typ.name as typename FROM oborudovanie
left outer join uz uz on uz.id_uz = oborudovanie.id_uz
left outer join type_oborudovanie typ on typ.id_type_oborudovanie = oborudovanie.id_type_oborudovanie
where oborudovanie.id_oborudovanie = '$id_oborudovanie'";
$result = $connectionDB->executeQuery($sql);
if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data = ['id_oborudovanie' => $row['id_oborudovanie']
        , 'typename' => $row['typename']
        , 'uz' => $row['uz']
        , 'date_dogovor_service' => $row['date_dogovor_service']
        , 'srok_dogovor_service' => $row['srok_dogovor_service']
        , 'summa_dogovor_service' => $row['summa_dogovor_service']
        , 'type_work_dogovor_service' => $row['type_work_dogovor_service']


        ];
    }
    echo json_encode($data);
} else {
    echo json_encode(array('empty' => true));
}

?>