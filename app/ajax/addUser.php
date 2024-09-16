<?php
include "../../connection/connection.php";

$uz_name = $_POST['uz_name'];
$login_org = $_POST['login_org'];
$password_org = $_POST['password_org'];

if(isset($_POST['sel_obl'])){
    $id_obl = $_POST['sel_obl'];
}
else if(isset($_POST['id_obl'])){
    $id_obl = $_POST['id_obl'];
}

$query = "select * from users where login = '$login_org' or username = '$uz_name'";
$result = mysqli_query($connectionDB->con, $query);

if($connectionDB->getNumRows($result) > 0){
    echo '0';
}
else{
    $query = "insert into uz (`name`, id_oblast) values ('$uz_name', '$id_obl')";
    mysqli_query($connectionDB->con, $query);
    $id_uz = mysqli_insert_id($connectionDB->con);
    $hash_password = md5($password_org);
    $query = "INSERT INTO users (username, login, password, id_role, id_uz) VALUES ('$uz_name', '$login_org', '$hash_password', '4', '$id_uz')";
    mysqli_query($connectionDB->con, $query);
    echo '1';
}
