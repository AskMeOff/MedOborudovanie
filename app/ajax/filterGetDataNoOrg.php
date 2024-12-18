<?php
include "../../connection/connection.php";
include "../classes/UsersList.php";
$equipment = $_POST['equipment'];

$id_uz = $usersList->getUser($_COOKIE['token'])->getIdUz();
$id_role = $usersList->getUser($_COOKIE['token'])->getRole();

$year = $_POST['year'];
$id_obl = $_POST['id_obl'];

$datePostavki = $_POST['datePostavki'];
$dateRelease = $_POST['dateRelease'];
$service = $_POST['service'];
$status = $_POST['status'];

if ($id_role == 4) {
    $sql = "SELECT oborudovanie.*, type_oborudovanie.name, uz.name as poliklinika, s.name as servname FROM oborudovanie 
                                        INNER JOIN uz on oborudovanie.id_uz=uz.id_uz
                                        left outer join type_oborudovanie on oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
                                        left outer join servicemans s on s.id_serviceman = oborudovanie.id_serviceman
                                        WHERE uz.id_oblast=$id_obl and uz.id_uz = $id_uz";
} else if ($id_role == 2 || $id_role == 1) {
    $sql = "SELECT oborudovanie.*, type_oborudovanie.name, uz.name as poliklinika, s.name as servname FROM oborudovanie 
                                        INNER JOIN uz on oborudovanie.id_uz=uz.id_uz
                                        left outer join type_oborudovanie on oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
                                        left outer join servicemans s on s.id_serviceman = oborudovanie.id_serviceman
                                        WHERE uz.id_oblast=$id_obl";
} else if ($id_role == 3) {
    $idoblguzo = $usersList->getOblastByToken($connectionDB->con, $_COOKIE['token']);
    if ($id_obl == $idoblguzo) {
        $sql = "SELECT oborudovanie.*, type_oborudovanie.name, uz.name as poliklinika, s.name as servname FROM oborudovanie 
                                        INNER JOIN uz on oborudovanie.id_uz=uz.id_uz
                                        left outer join type_oborudovanie on oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
                                        left outer join servicemans s on s.id_serviceman = oborudovanie.id_serviceman
                                        WHERE uz.id_oblast=$id_obl";
    } else {
        echo "Данные недоступны для вашей области.";
        exit;
    }
} else {
    echo "Данные недоступны. Требуется Авторизация";
    exit;
}

if (!empty($equipment)) {
    $sql .= " AND type_oborudovanie.name LIKE '%" . $connectionDB->escapeString($equipment) . "%'";
}
if (!empty($year)) {
    $sql .= " AND oborudovanie.date_create = '" . $connectionDB->escapeString($year) . "'";
}
if (!empty($datePostavki)) {
    $sql .= " AND oborudovanie.date_postavki = '" . $connectionDB->escapeString($datePostavki) . "'";
}
if (!empty($dateRelease)) {
    $sql .= " AND oborudovanie.date_release = '" . $connectionDB->escapeString($dateRelease) . "'";
}
if (!empty($service)) {
    $sql .= " AND s.name LIKE '%" . $connectionDB->escapeString($service) . "%'";
}
if (!empty($status) && $status !== "Все") {
    $statusValue = ($status === "исправно") ? "1" : (($status === "Работа в ограниченном режиме") ? "3" : "0");
    $sql .= " AND oborudovanie.status = '" . $connectionDB->escapeString($statusValue) . "'";
}

$result = $connectionDB->executeQuery($sql);
$output = '<div class="table-responsive">
                        <table class="table table-striped table-responsive-sm dataTable no-footer" id="infoObAll"   style="display: none">
                            <thead>                    
                                <tr>
                                <th>!!!</th>
                                <th>Организация</th>
                                <th>Вид оборудования</th>
                                <th>Модель, производитель</th>
                                <th>Регистрационный номер оборудования</th>
                                <th>Серийный(заводской) номер</th>
                                <th>Год производства</th>
                                <th>Дата поставки</th>
                                <th>Дата ввода в эксплуатацию</th>
                                <th>Сервисная организация</th>
                                <th>Дата последнего ТО</th>
                                <th>Статус </th>
                            </tr>
                            </thead>
                            <tbody>';

$result1 = $connectionDB->executeQuery($sql);
while ($row = mysqli_fetch_assoc($result1)) {
    $poliklinika = $row['poliklinika'];
    $nameOborudov = $row['name'];
    $idOborudovanie = $row['id_oborudovanie'];
    $model = $row['model'];
    $serial_number = $row['serial_number'];
    $zavod_nomer = $row['zavod_nomer'];
    $mark1 = empty($serial_number) || empty($nameOborudov) ? '<span style="color: red; font-size: 20px;">!</span>' : '';
    $currentStatus = $row['status'];

    if ($currentStatus == "1") {
        $color = "green";
        $statusText = "исправно";
    } else if ($currentStatus == "3") {
        $color = "orange";
        $statusText = "Работа в ограниченном режиме";
    } else if ($currentStatus == "0") {
        $color = "red";
        $statusText = "неисправно";
    }

    $output .= '<tr id="idob' . $idOborudovanie . '">';
    $output .= '<td>' . $mark1 . '</td>';
    $output .= '<td>' . $poliklinika . '</td>';
    $output .= '<td onclick="getEffectTable(' . $idOborudovanie . ')" style="cursor: pointer; color: #167877; font-weight: 550;">' . $nameOborudov . '</td>';
    $output .= '<td>' . $model . '</td>';
    $output .= '<td>' . $serial_number . '</td>';
    $output .= '<td>' . $zavod_nomer . '</td>';
    $date_create = $row['date_create'];
    $output .= '<td>' . $date_create . '</td>';

    $date_postavki = $row['date_postavki'];
    $output .= '<td>' . ($date_postavki ? date('d.m.Y', strtotime($date_postavki)) : 'Нет данных') . '</td>';

    $date_release = $row['date_release'];
    $output .= '<td>' . ($date_release ? date('d.m.Y', strtotime($date_release)) : 'Нет данных') . '</td>';

    $output .= '<td>' . $row['servname'] . '</td>';

    $date_last_TO = $row['date_last_TO'];
    $output .= '<td>' . ($date_last_TO ? date('d.m.Y', strtotime($date_last_TO)) : 'Нет данных') . '</td>';
    $output .= '<td>';
    $output .= '<div style="border-radius: 5px; background-color: ' . $color . '; color: white; padding: 5px;">' . $statusText . '</div>';
    $output .= '</td>';
    $output .= '</tr>';
}

$output.= '  </tbody>
                        </table>
                    </div>';

echo $output;
?>