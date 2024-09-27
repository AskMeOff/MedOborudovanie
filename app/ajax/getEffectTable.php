<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}
$id_oborudovanie = $_GET['id_oborudovanie'];
$sql = "SELECT * FROM use_efficiency where id_oborudovanie = '$id_oborudovanie'";
$result = $connectionDB->executeQuery($sql);
if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = array('count_research' => $row['count_research']
        , 'count_patient' => $row['count_patient']
        , 'id_use_efficiency' => $row['id_use_efficiency']
        , 'data_year_efficiency' => $row['data_year_efficiency']
        , 'data_month_efficiency' => $row['data_month_efficiency']
        );
    }
    echo json_encode($data);
} else {
    echo json_encode(array('empty' => true));
}

?>