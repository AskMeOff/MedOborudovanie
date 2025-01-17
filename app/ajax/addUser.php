<?php
include "../../connection/connection.php";

$uz_name = $_POST['uz_name'];
$uz_unp = $_POST['uz_unp'];
$login_org = $_POST['login_org'];
$password_org = $_POST['password_org'];
$email = $_POST['email'];

if(isset($_POST['sel_obl'])){
    $id_obl = $_POST['sel_obl'];
}
else if(isset($_POST['id_obl'])){
    $id_obl = $_POST['id_obl'];
}

if (isset($_FILES['zayavka'])) {
    $fileTmpPath = $_FILES['zayavka']['tmp_name'];
    $fileName = $_FILES['zayavka']['name'];
    $fileSize = $_FILES['zayavka']['size'];
    $fileType = $_FILES['zayavka']['type'];

    $uploadFileDir = '../../documents/zayavki/';
    $dest_path = $uploadFileDir . $fileName;

    if (move_uploaded_file($fileTmpPath, $dest_path)) {
        echo "1";
    } else {
        echo "0";
    }
}

$query = "select * from users where login = '$login_org' or username = '$uz_name'";
$result = mysqli_query($connectionDB->con, $query);

if($connectionDB->getNumRows($result) > 0){
    echo '0';
}
else{
    $query = "insert into uz (`name`, id_oblast, `unp`) values ('$uz_name', '$id_obl' , '$uz_unp')";
    mysqli_query($connectionDB->con, $query);
    $id_uz = mysqli_insert_id($connectionDB->con);
    $hash_password = md5($password_org);
    $query = "INSERT INTO users (username, login, password, id_role, id_uz, email, zayavka) VALUES ('$uz_name', '$login_org', '$hash_password', '4', '$id_uz' , '$email', '$dest_path')";
    mysqli_query($connectionDB->con, $query);
    echo '1';
}
