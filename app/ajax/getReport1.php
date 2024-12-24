<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}

$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$id_uz = isset($_POST['id_uz']) ? $_POST['id_uz'] : null;
$sql = "SELECT DISTINCT tfbd.id_oborudovanie, uz.name as uz_name, `to`.name as type_name, s.name as serv_name FROM table_faults_by_date tfbd 
    LEFT JOIN oborudovanie o ON tfbd.id_oborudovanie=o.id_oborudovanie
    LEFT JOIN uz uz ON o.id_uz=uz.id_uz
    LEFT JOIN type_oborudovanie `to` ON o.id_type_oborudovanie=`to`.id_type_oborudovanie
    LEFT JOIN servicemans s ON o.id_serviceman=s.id_serviceman
WHERE uz.name IS NOT NULL 
AND `to`.name IS NOT NULL";
$conditions = [];

if ($startDate && $endDate) {
    $sql .= " AND tfbd.date BETWEEN '$startDate' AND '$endDate'";
}

if ($id_uz && $id_uz != '0') {
    $conditions[] = "uz.id_uz = '$id_uz'";
}

if (count($conditions) > 0) {
    $sql .= " AND " . implode(" AND ", $conditions);
}

$output = '<table class="table table-striped table-responsive-sm dataTable no-footer" id="table_report1"
                           style="display: block">
                        <thead>
                        <tr>
                            <th>Организация</th>
                            <th>Вид оборудования</th>
                            <th>Сервисная организация</th>

                        </tr>
                        </thead>
                        <tbody>';
$result = $connectionDB->executeQuery($sql);
if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>";
        $output .= "<td>" . $row['uz_name'] . "</td>";
        $output .= "<td>" . $row['type_name'] . "</td>";
        $output .= "<td>" . $row['serv_name'] . "</td>";
        $output .= "</tr>";
    }
}
$output.= "</tbody></table>";
echo $output;
?>