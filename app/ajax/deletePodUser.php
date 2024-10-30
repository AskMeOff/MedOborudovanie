<?php
include "../../connection/connection.php";
include '../classes/UsersList.php';

$id_user = $_GET['id_user'];

$usersList = new UsersList();
$connectionDB = new ConnectionDB();
$usersList->setListFromDB($connectionDB->con);

$user = $usersList->getUserById($id_user);
if ($user) {
    $id_uz = $user->getIdUz();
    $usersList->deleteUser($connectionDB->con, $id_user);
    $sqlUz = "DELETE FROM uz WHERE id_uz = '$id_uz'";
    mysqli_query($connectionDB->con, $sqlUz);
echo json_encode(['success' => true, 'message' => 'Пользователь и его данные удалены.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Пользователь не найден.']);
}
?>