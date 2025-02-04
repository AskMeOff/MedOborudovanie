<?php
include "../../connection/connection.php";

ini_set("session.use_trans_sid", true);
session_start();

if (isset($_POST["login"]) && isset($_POST["password"])) {
    $login = trim(str_replace(array("\r", "\n", ' '), '', $_POST["login"]));
    $password = trim(str_replace(array("\r", "\n", ' '), '', $_POST["password"]));
    $hashPassword = md5($password);

    $query = "select * from users where trim(login) = trim('$login') and trim(password) = trim('$hashPassword') and removed_at is null";
    $result = $connectionDB->executeQuery($query);
    if ($connectionDB->getNumRows($result) == 1) {
        $row = $connectionDB->getRowResult($result);
        $active = $row['active'];
        if ($active == "0"){
            echo "2";
            return;
        }
        $id_user = $row['id_user'];
        $email = $row['email'];
        $password = $row['password'];
        $login = $row['login'];
        $username = $row['username'];
        $token = md5($hashPassword . $login);
        $connectionDB->executeQuery("update users set token = '$token' where id_user = '$id_user'");
        setcookie("login", $login, time() + (86400 * 30), "/");
        setcookie("token", md5($hashPassword . $login), time() + (86400 * 30), "/");
        echo true;
    } else echo false;
}

