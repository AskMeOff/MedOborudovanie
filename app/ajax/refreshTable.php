<?php
include "../../connection/connection.php";
$id_oborudovanie = $_GET['id_oborudovanie'];

$sql = "SELECT oborudovanie.*, type_oborudovanie.name FROM oborudovanie
        left outer join type_oborudovanie on oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
        where id_oborudovanie = '$id_oborudovanie'";
$result = $connectionDB->executeQuery($sql);
$response = array();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    foreach($row as $key => $value) {
        $response[$key] = $value;
    }
}
echo json_encode($response);
?>