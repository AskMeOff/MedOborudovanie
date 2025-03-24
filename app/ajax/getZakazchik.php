<?php
include '../../connection/connection.php';
$id_zakazchik = $_POST['id'] ?? '';

        $query = "SELECT * FROM zakazchik where id_zakazchik = $id_zakazchik";
$result = mysqli_query($connectionDB->con, $query);
$row = mysqli_fetch_assoc($result);
$obj = [
    'nameZakazchik' => $row['nameZakazchik'],
    'dolzhnostIP' => $row['dolzhnostIP'],
    'dolzhnostRP' => $row['dolzhnostRP'],
    'fioIP' => $row['fioIP'],
    'fioRP' => $row['fioRP'],
    'osnovanie' => $row['osnovanie'],
    'rekvizit' => $row['rekvizit'],
    'contact' => $row['contact'],
    'email' => $row['email'],
    'pochtaIndex' => $row['pochtaIndex'],
    'primechanie' => $row['primechanie'],
];
//echo $row['dolzhnostIP'];
//echo $row['dolzhnostRP'];
//echo $row['fioIP'];
//echo $row['fioRP'];
//echo $row['osnovanie'];
//echo $row['rekvizit'];
//echo $row['contact'];
//echo $row['email'];
//echo $row['pochtaIndex'];
//echo $row['primechanie'];
echo json_encode($obj);
?>