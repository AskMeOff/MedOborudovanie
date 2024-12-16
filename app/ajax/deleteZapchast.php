<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['id_zapchast'])) {
    $id_zapchast = $_POST['id_zapchast'];
    $sql = "DELETE from zapchasti where id_zapchast = '$id_zapchast'";
    $result = $connectionDB->executeQuery($sql);
    echo "Запись успешно удалена.";
}else {
    echo "id_oborudovanie не предоставлен.";
}

