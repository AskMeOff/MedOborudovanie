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
        , 'cost' => $row['cost']
        , 'num_and_date' => $row['num_and_date']
        , 'model_prozvoditel' => $row['model']
        , 'date_dogovora' => $row['date_dogovora']
        , 'service_organization' => $row['id_serviceman']
        , 'service_postavschik' => $row['id_postavschik']
        , 'date_get_sklad' => $row['date_get_sklad']
        , 'date_norm_srok_vvoda' => $row['date_norm_srok_vvoda']
        , 'reasons' => $row['reasons']
        , 'status' => $row['status']

        ];
    }
    echo json_encode($data);
} else {
    echo json_encode(array('empty' => true));
}

?>