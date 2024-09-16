<?php
include "../../connection/connection.php";

$id_us = $_POST['id'];
$newPass = $_POST['newPass'];


$newPass = md5($newPass);
$query = "update users set password = '$newPass' where id_user = '$id_us'";
$result = mysqli_query($connectionDB->con, $query);
echo "1";