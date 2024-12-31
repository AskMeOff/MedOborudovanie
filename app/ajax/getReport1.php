<?php
include "../../connection/connection.php";
if (!$connectionDB) {
    die("Connection failed: " . mysqli_connect_error());
}

$startDate = isset($_POST['startDate']) ? $_POST['startDate'] : null;
$endDate = isset($_POST['endDate']) ? $_POST['endDate'] : null;
$id_uz = isset($_POST['id_uz']) ? $_POST['id_uz'] : null;
$sql = "SELECT  
    o.id_oborudovanie, 
    uz.name AS uz_name, 
    `to`.name AS type_name, 
    o.model as model, 
    s.name AS serv_name, 
    fa.date_fault as datfault,
    DATEDIFF(IFNULL(fa.date_remont, CURDATE()), fa.date_fault) AS days_of_downtime
FROM 
    oborudovanie o 
    left JOIN faults fa ON o.id_oborudovanie = fa.id_oborudovanie
    right JOIN uz uz ON o.id_uz = uz.id_uz
    left JOIN type_oborudovanie `to` ON o.id_type_oborudovanie = `to`.id_type_oborudovanie
    left JOIN servicemans s ON o.id_serviceman = s.id_serviceman
WHERE 
     o.status = 0
     group by o.id_oborudovanie";
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
                            <th>Наименование оборудования</th>
                            <th>Дата поломки</th>
                            <th>Дни простоя</th>
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
        $output .= "<td>" . $row['model'] . "</td>";
        $output .= "<td>" . $row['datfault'] . "</td>";
        $output .= "<td>" . $row['days_of_downtime'] . "</td>";
        $output .= "<td>" . $row['serv_name'] . "</td>";
        $output .= "</tr>";
    }
}
$output.= "</tbody></table>";
echo $output;
?>