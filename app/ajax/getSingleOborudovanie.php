<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}
$id_oborudovanie = $_GET['id_oborudovanie'];
$sql = "SELECT * FROM oborudovanie
where id_oborudovanie = '$id_oborudovanie'";
$result = $connectionDB->executeQuery($sql);
if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data = ['id_oborudovanie' => $row['id_oborudovanie']
        , 'id_type_oborudovanie' => $row['id_type_oborudovanie']
        , 'id_uz' => $row['id_uz']
//        , 'cost' => $row['cost']
        , 'date_create' => $row['date_create']
        , 'date_postavki' => $row['date_postavki']
        , 'date_release' => $row['date_release']
        , 'model_prozvoditel' => $row['model']
        , 'serial_number' => $row['serial_number']
        , 'zavod_nomer' => $row['zavod_nomer']
        , 'date_dogovora' => $row['date_dogovora']
        , 'service_organization' => $row['id_serviceman']
        , 'date_last_TO' => $row['date_last_TO']
        , 'status' => $row['status']
        , 'id_from_reestr' => $row['id_from_reestr']

        ];
    }
    echo json_encode($data);
} else {
    echo json_encode(array('empty' => true));
}

?>