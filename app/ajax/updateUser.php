<?php
include "../../connection/connection.php";

$id_user = $_POST['id_user'];
$uz_name = $_POST['uz_name'];
$uz_unp = $_POST['uz_unp'];
$login_org = $_POST['login_org'];
$password_org = $_POST['password_org'];
$email = $_POST['email'];


if (!empty($password_org)) {
    $hash_password = md5($password_org);
    $query = "UPDATE users SET username = '$uz_name', login = '$login_org', password = '$hash_password', email = '$email' WHERE id_user = '$id_user'";
} else {
    $query = "UPDATE users SET username = '$uz_name', login = '$login_org', email = '$email' WHERE id_user = '$id_user'";
}


if (mysqli_query($connectionDB->con, $query)) {

    $queryUz = "UPDATE uz SET name = '$uz_name', unp = '$uz_unp' WHERE id_uz = (SELECT id_uz FROM users WHERE id_user = '$id_user')";
    mysqli_query($connectionDB->con, $queryUz);

    echo '1';
} else {
    echo '0';
}
?>