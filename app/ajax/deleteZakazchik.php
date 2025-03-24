<?php
include '../../connection/connection.php';
if (isset($_POST['id_zakazchik'])) {
    $id_zakazchik = $_POST['id_zakazchik'];
    $query = "DELETE FROM zakazchik WHERE id_zakazchik = $id_zakazchik";
    $result = $connectionDB->executeQuery($query);

    if ($result) {
        echo "success";
    } else {
        echo "error";
    }
}
