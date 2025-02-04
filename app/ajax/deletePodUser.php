<?php
include "../../connection/connection.php";
include '../classes/UsersList.php';

$id_user = $_GET['id_user'];
$login = $_COOKIE['login'];

$usersList = new UsersList();
$connectionDB = new ConnectionDB();
$usersList->setListFromDB($connectionDB->con);

$user = $usersList->getUserById($id_user);
if ($user) {
    $usersList->deleteUser($connectionDB->con, $id_user, $login);
echo json_encode(['success' => true, 'message' => 'Пользователь и его данные удалены.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Пользователь не найден.']);
}
?>