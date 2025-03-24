<?php
include '../../connection/connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_zakazchik = $_POST['id_zakazchik'];
    $field = $_POST['field'];
    $value = $_POST['value'];

    $query = "UPDATE zakazchik SET $field = '$value' WHERE id_zakazchik = $id_zakazchik";
    $result = $connectionDB->executeQuery($query);

    if ($result) {
        echo "success";
    } else {
        echo "error";
    }
}
?>