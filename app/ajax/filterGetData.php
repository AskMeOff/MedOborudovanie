<?php
include "../../connection/connection.php";
$equipment = $_POST['equipment'];
$id_uz = $_POST['id_uz'];
$year = $_POST['year'];
$datePostavki = $_POST['datePostavki'];
$dateRelease = $_POST['dateRelease'];
$service = $_POST['service'];
$status = $_POST['status'];
$sql = "SELECT oborudovanie.*, type_oborudovanie.name, s.name as servname FROM oborudovanie
        LEFT JOIN type_oborudovanie ON oborudovanie.id_type_oborudovanie = type_oborudovanie.id_type_oborudovanie
        LEFT JOIN servicemans s ON s.id_serviceman = oborudovanie.id_serviceman
        WHERE oborudovanie.id_uz = $id_uz";

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
if (!empty($status)) {
    $statusValue = ($status === "исправно") ? "1" : "0";
    $sql .= " AND oborudovanie.status = '" . $connectionDB->escapeString($statusValue) . "'";
}

$result = $connectionDB->executeQuery($sql);
$output = '<div class="table-responsive">
                        <table class="table table-striped table-responsive-sm dataTable no-footer" id="infoOb' . $id_uz . '"
                               style="display: none">
                            <thead>                    
                                <tr>
                                <th>Вид оборудования</th>
                                <th>Модель, производитель</th>
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
    $status = $row['status'] === "1" ? "исправно" : "неисправно";


    $output .= '<tr id="idob' . $idOborudovanie . '">';
    $output .= '<td onclick="getEffectTable(' . $idOborudovanie . ')" style="cursor: pointer; color: #167877; font-weight: 550;">' . $nameOborudov . '</td>';
    $output .= '<td>' . $model . '</td>';
    $output .= '<td>' . $row['date_create'] . '</td>';
    $output .= '<td>' . $row['date_postavki'] . '</td>';
    $output .= '<td>' . $row['date_release'] . '</td>';
    $output .= '<td>' . $row['servname'] . '</td>';
    $output .= '<td>' . $row['date_last_TO'] . '</td>';
    $output .= '<td onclick="getFaultsTable(' . $idOborudovanie . ')" style="cursor: pointer">';
    $output .= '<div style="border-radius: 5px; background-color: ' . ($status === "исправно" ? 'green' : 'red') . '; color: white; padding: 5px;">' . $status . '</div>';
    $output .= '</td>';
    $output .= '<td><a href="#" onclick="confirmDeleteOborudovanie(' . $idOborudovanie . ')">&#10060;</a>';
    $output .= '<a href="#" onclick="editOborudovanie(' . $idOborudovanie . ')">✏️</a></td>';
    $output .= '</tr>';
}

$output.= '  </tbody>
                        </table>
                    </div>';

echo $output;
?>