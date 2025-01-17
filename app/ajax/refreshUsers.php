<?php
include "../../connection/connection.php";

$zayavka = $_GET['zayavka'];

if($zayavka === "true"){
    $sql = "select id_user, email, uz.name, uz.unp,  login, password, zayavka, `active` from users
                left join uz on uz.id_uz = users.id_uz
                where users.id_role = 4 and zayavka is not null;
        ";
}else{
    $sql = "select id_user, email, uz.name, uz.unp,  login, password, zayavka, `active` from users
                left join uz on uz.id_uz = users.id_uz
                where users.id_role = 4;
        ";
}

$sql = "select id_user, email, uz.name, uz.unp,  login, password, zayavka, `active` from users
                left join uz on uz.id_uz = users.id_uz
                where users.id_role = 4
        ";
$result = $connectionDB->executeQuery($sql);
//коммит
if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {

        $data[] = array(
            'name' => $row['name'] ?? "Нет данных",
        'unp' => $row['unp'],
        'email' => $row['email'],
        'id_user' => $row['id_user'],
        'loginOrg' => $row['login'],
        'password' => $row['password'],
        'zayavka' => $row['zayavka'],
        'active' => $row['active'],

        );
    }
    echo json_encode($data);
} else {
    echo json_encode(array('empty' => true));
}
?>