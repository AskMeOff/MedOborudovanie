<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}
$id_oborudovanie = $_GET['id_oborudovanie'];
$sql = "SELECT * FROM faults where id_oborudovanie = '$id_oborudovanie'";
$result = $connectionDB->executeQuery($sql);
if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
          'date_fault' => $row['date_fault']
        , 'date_call_service' => $row['date_call_service']
        , 'reason_fault' => $row['reason_fault']
        , 'date_procedure_purchase' => $row['date_procedure_purchase']
        , 'date_dogovora' => $row['date_dogovora']
        , 'cost_repair' => $row['cost_repair']
        , 'time_repair' => $row['time_repair']
        , 'downtime' => $row['downtime']
        , 'id_fault' => $row['id_fault']

        );
    }
    echo json_encode($data);
} else {
    echo json_encode(array('empty' => true));
}

?>