<?php
include "../../connection/connection.php";
include '../classes/UsersList.php';

$id_user = $_GET['id_user'];

$usersList = new UsersList();
$connectionDB = new ConnectionDB();

$usersList->deleteUser($connectionDB->con, $id_user);

echo json_encode(['success' => true, 'message' => 'Пользователь удален.']);
?>