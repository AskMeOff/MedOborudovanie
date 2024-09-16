<?php
include "../../connection/connection.php";

if (isset($_POST['id_user'])) {
    $id_user = intval($_POST['id_user']);

    $query = "DELETE FROM users WHERE id_user = '$id_user'";
    if ($connectionDB->executeQuery($query)) {
        echo "1";
    } else {
        echo "0";
    }
} else {
    echo "0";
}
?>