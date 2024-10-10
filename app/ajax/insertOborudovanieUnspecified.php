
<?php
include "../../connection/connection.php";
include "../classes/UsersList.php";

$id_uz = $usersList->getUser($_COOKIE['token'])->getIdUz();

$id_type_oborudovanie = $_POST['id_type_oborudovanie'];
$cost = $_POST['cost'];
$model = $_POST['model'];
$contract = $_POST['contract'];
$id_serviceman = $_POST['id_serviceman'];
$id_postavschik = $_POST['id_postavschik'];
$date_get_sklad = $_POST['date_get_sklad'];
$date_srok_vvoda = $_POST['date_srok_vvoda'] ;
$reasons = $_POST['reasons'];
$num_and_date = $_POST['contract'];

$sql = "INSERT INTO oborudovanie (id_type_oborudovanie, cost, model, num_and_date, id_serviceman, id_postavschik, date_get_sklad, date_norm_srok_vvoda, reasons, id_uz, status)
        VALUES ($id_type_oborudovanie, $cost, '$model', '$num_and_date', $id_serviceman, $id_postavschik, '$date_get_sklad', '$date_srok_vvoda', '$reasons', $id_uz, 2);";

try {
    $result = $connectionDB->executeQuery($sql);
    echo 1;
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
    echo "SQL запрос: " . $sql; // Для отладки
}
?>