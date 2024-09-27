<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}
$id_use_efficiency = $_GET['id_use_efficiency'];
$sql = "SELECT * FROM use_efficiency where id_use_efficiency = '$id_use_efficiency'";
$result = $connectionDB->executeQuery($sql);
if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data = ['id_use_efficiency' => $row['id_use_efficiency']
        , 'count_research' => $row['count_research']
        , 'count_patient' => $row['count_patient']
            , 'data_year_efficiency' => $row['data_year_efficiency']
            , 'data_month_efficiency' => $row['data_month_efficiency']
        ];
    }
    echo json_encode($data);
} else {
    echo json_encode(array('empty' => true));
}

?>