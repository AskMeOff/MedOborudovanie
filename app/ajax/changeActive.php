<?php
include "../../connection/connection.php";

$id_user = $_POST['id_user'];
$active = $_POST['active'];
$bool_active = $active == "true" ? 1 : 0;

$query = "update users set `active` = '$bool_active' where id_user = '$id_user' ";

$result = mysqli_query($connectionDB->con, $query);

if ($result) {
    echo "1";
} else {
    echo "0";
}
