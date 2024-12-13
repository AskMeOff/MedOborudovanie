<?php
include "../../connection/connection.php";
$equipment = $_POST['equipment'];
$id_uz = $_POST['id_uz'];
$year = $_POST['year'];
$datePostavki = $_POST['datePostavki'];
$dateRelease = $_POST['dateRelease'];
$service = $_POST['service'];
$status = $_POST['status'];
$id_type_oborudovanie = isset($_POST['id_type_oborudovanie']) ? $_POST['id_type_oborudovanie'] : null;
$sql = "SELECT oborudovanie.*, type_oborudovanie.name, s.name as servname FROM oborudovanie
        LEFT JOIN type_oborudovanie ON oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
        LEFT JOIN servicemans s ON s.id_serviceman = oborudovanie.id_serviceman
        WHERE oborudovanie.id_uz = $id_uz";



if (!empty($equipment)) {
    $sql .= " AND type_oborudovanie.name LIKE '%" . $connectionDB->escapeString($equipment) . "%'";
}else{
    if (!empty($id_type_oborudovanie)) {
        $sql .= " AND oborudovanie.id_type_oborudovanie = " . $connectionDB->escapeString($id_type_oborudovanie);
    }
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
    if($status === "исправно"){
        $statusValue=1;
    }else {
    $statusValue = (($status === "Работа в ограниченном режиме") ? "3" : "0");
    }
    $sql .= " AND oborudovanie.status = '" . $connectionDB->escapeString($statusValue) . "'";
    /*($status === "исправно") ? "1" :*/
}else {
    $sql .= " AND oborudovanie.status in (0,1,3)";
}


$result = $connectionDB->executeQuery($sql);
$output = '<div class="table-responsive">
                        <table class="table table-striped table-responsive-sm dataTable no-footer" id="infoOb' . $id_uz . '"
                               style="display: none">
                            <thead>                    
                                <tr>
                                <th>!!!</th>
                                <th>Вид оборудования</th>
                                <th>Модель, производитель</th>
                                <th>Серийный(заводской) номер оборудования</th>
                                <th>Год производства</th>
                                <th>Дата поставки</th>
                                <th>Дата ввода в эксплуатацию</th>
                                <th>Сервисная организация</th>
                                <th>Дата последнего ТО</th>
                                <th>Статус </th>
                                <th>Действия </th>
                            </tr>
                            </thead>
                            <tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    $nameOborudov = $row['name'];
    $idOborudovanie = $row['id_oborudovanie'];
    $model = $row['model'];
    $serial_number = $row['serial_number'];
    $mark1 = empty($serial_number) ? '<span style="color: red; font-size: 20px;">!</span>' : '';
    $status = ($row['status'] === "1") ? "исправно" : (($row['status'] === "3") ? "Работа в ограниченном режиме" : "неисправно");



    $output .= '<tr id="idob' . $idOborudovanie . '">';
    $output .= '<td>' . $mark1 . '</td>';
    $output .= '<td onclick="getEffectTable(' . $idOborudovanie . ')" style="cursor: pointer; color: #167877; font-weight: 550;">' . $nameOborudov . '</td>';
    $output .= '<td>' . $model . '</td>';
    $output .= '<td>' . $serial_number . '</td>';
    $date_create = $row['date_create'];
    $output .= '<td>' . $date_create . '</td>';

    $date_postavki = $row['date_postavki'];
    $output .= '<td>' . ($date_postavki ? date('d.m.Y', strtotime($date_postavki)) : 'Нет данных') . '</td>';

    $date_release = $row['date_release'];
    $output .= '<td>' . ($date_release ? date('d.m.Y', strtotime($date_release)) : 'Нет данных') . '</td>';

    $output .= '<td>' . $row['servname'] . '</td>';

    $date_last_TO = $row['date_last_TO'];
    $output .= '<td>' . ($date_last_TO ? date('d.m.Y', strtotime($date_last_TO)) : 'Нет данных') . '</td>';

    $output .= '<td onclick="getFaultsTable(' . $idOborudovanie . ')" style="cursor: pointer">';
    if($status=== "исправно")
    {
        $color = "green";
    }
    else if ($status === "Работа в ограниченном режиме")
    {
        $color = "orange";
    }
    else {
        $color = "red";
    }
    $output .= '<div style="border-radius: 5px; background-color: ' . $color . '; color: white; padding: 5px;">' . $status . '</div>';
    $output .= '</td>';
    $output .= '<td><a href="#" onclick="editOborudovanie(' . $idOborudovanie . ')"><i class="fa fa-edit" style="font-size: 20px;"></i>️</a>';
    $output .= '<a href="#" onclick="confirmDeleteOborudovanie(' . $idOborudovanie . ')"><i class="fa fa-trash" style="font-size: 20px;"></i></a>
 <a href="#" onclick="duplicateOborudovanie(' . $idOborudovanie . ')"><i class="fa fa-copy" style="font-size: 20px;"></i></a> 
 </td>';
    $output .= '</tr>';
}

$output.= '  </tbody>
                        </table>
                    </div>';

echo $output;
?>