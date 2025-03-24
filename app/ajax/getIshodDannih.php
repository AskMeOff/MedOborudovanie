<?php
include '../../connection/connection.php';
$pasport_zdanie = $_POST['pasportZD'] ?? '';
$hard_zdanie = $_POST['hardZdanie'] ?? '';
$visota_zdanie = $_POST['valVisZd'] ?? '';
$etazh = $_POST['etazh'] ?? '';
$P212 = $_POST['P212'] ?? '';
$arr = array();
if (empty($pasport_zdanie) || empty($hard_zdanie) || empty($visota_zdanie)) {
    array_push($arr, 1);
    array_push($arr, 1);
} else {

    if ($etazh < 2)
        $nametable = 'table_ishod_dannih';
    else
        $nametable = 'table_ishod_dannih_mnogoetazh';

    $query = "SELECT * FROM $nametable where pasport_zdanie ='$pasport_zdanie'and hard_zdanie ='$hard_zdanie' and visota_zdanie = '$visota_zdanie' ";
    $result = mysqli_query($connectionDB->con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        array_push($arr, $row['ishod_value']);
    } else {
        array_push($arr, 1);
    }
    $query = "SELECT ki FROM tarifs where p ='$P212' ";
    $result = mysqli_query($connectionDB->con, $query);
    $row = mysqli_fetch_assoc($result);
    array_push($arr, $row['ki']);
    echo json_encode($arr);

}

?>