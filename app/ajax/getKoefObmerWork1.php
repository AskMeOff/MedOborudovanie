<?php
include '../../connection/connection.php';
$kat_sl_zd = $_POST['kat_sl_zd'] ?? '';
$kat_sl_rab = $_POST['kat_sl_rab'] ?? '';
$vysota = $_POST['vysota'] ?? '';
$etazh = $_POST['etazh'] ?? '';
$P222 = $_POST['P222'] ?? '';
$arr = array();
if (empty($kat_sl_zd) || empty($kat_sl_rab) || empty($vysota)) {
    array_push($arr, 1);
    array_push($arr, 1);
} else {

    if ($etazh < 2)
        $nametable = 'table2_5';
    else
        $nametable = 'table2_6';

    $query = "SELECT * FROM $nametable where kat_sl_zd ='$kat_sl_zd'and kat_sl_rab ='$kat_sl_rab' and vysota = '$vysota' ";
    $result = mysqli_query($connectionDB->con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        array_push($arr, $row['koef']);
    } else {
        array_push($arr, 1);
    }
    $query = "SELECT ki FROM tarifs where p ='$P222' ";
    $result = mysqli_query($connectionDB->con, $query);
    $row = mysqli_fetch_assoc($result);
    array_push($arr, $row['ki']);
    echo json_encode($arr);
}

?>